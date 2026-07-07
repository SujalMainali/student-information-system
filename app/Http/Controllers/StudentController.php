<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Student;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    private const PAGE_SIZE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::query()
            ->select(['id', 'name', 'email', 'dob'])
            ->orderBy('id')
            ->with([
                'user' => fn ($query) => $query
                    ->select('id', 'name', 'email')
                    ->with(['image' => fn ($query) => $query->select('id', 'image_path', 'imageable_id')]),
            ])
            ->paginate(self::PAGE_SIZE);

        if ($students->currentPage() > $students->lastPage()) {
            return redirect()->route('student.index');
        }

        if(request()->expectsJson()) {
            return response()->json([
                'message' => 'Students retrieved successfully.',
                'data' => StudentResource::collection($students),
            ], 200);
        }

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $validatedData = $request->validated();
        $student = Student::create(
            [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'dob' => $validatedData['dob'],
            ]
        );

        if($student->user()->first()?->exists()) {
            if ($request->hasFile('profile_image')) {
                $validatedData['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
                $student->user()->first()->image()->create(['image_path' => $validatedData['profile_image']]);
            }
        }

        if($request->expectsJson()) {
            return response()->json([
                'message' => 'Student created successfully.',
                'data' => new StudentResource($student),
            ], 201);
        }

        return redirect()
            ->route('student.show', $student)
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        Gate::authorize('view', $student);
        $student->load([
            'courses' => fn ($query) => $query
                ->select('courses.id', 'courses.name', 'courses.credits')
                ->orderBy('courses.name'),
            'user' => fn ($query) => $query
                ->select('id', 'name', 'email')
                ->with(['image' => fn ($query) => $query->select('id', 'image_path', 'imageable_id')]),
        ]);

        if(request()->expectsJson()) {
            return response()->json([
                'message' => 'Student retrieved successfully.',
                'data' => new StudentResource($student),
            ], 200);
        }

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $isAdmin = auth()->user()->isAdmin();
        return view('students.edit', compact('student','isAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRequest $request, Student $student)
    {
        $validatedData = $request->validated();
        $student->update($validatedData);

        if($student->user()->exists()) {
            if( $request->hasFile('profile_image')){
                if ($student->user()->first()?->image()->first()?->exists()) {
                    Storage::disk('public')->delete($student->user()->first()->image()->first()->image_path);
                }
                $validatedData['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
                $student->user()->first()->image()->updateOrCreate(
                    [],
                    ['image_path' => $validatedData['profile_image']]
                );
            }
        }

        if($request->expectsJson()) {
            return response()->json([
                'message' => 'Student updated successfully.',
                'data' => new StudentResource($student),
            ], 200);
        }

        return redirect()
            ->route('student.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        Gate::authorize('delete', $student);

        if ($student->profile_image) {
            Storage::disk('public')->delete($student->profile_image);
        }
        $student->delete();

        if(request()->expectsJson()) {
            return response()->noContent();
        }
            
        return redirect()
            ->route('student.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Display the student's course enrollment checklist.
     */
    public function courses(Student $student)
    {
        Gate::authorize('view', $student);
        $courses = Course::query()
            ->select(['id', 'name', 'credits'])
            ->orderBy('name')
            ->get();

        $enrolledCourseIds = $student->courses()
            ->pluck('courses.id')
            ->all();

        return view('students.courses', compact('student', 'courses', 'enrolledCourseIds'));
    }

    /**
     * Update the student's course enrollments.
     */
    public function updateCourses(UpdateCourseRequest $request, Student $student)
    {
        Gate::authorize('update', $student);
        $selectedCourseIds = collect($request->validated('courses', []))
            ->map(fn ($courseId) => (int) $courseId)
            ->unique()
            ->values();

        $currentCourseIds = $student->courses()
            ->pluck('courses.id')
            ->map(fn ($courseId) => (int) $courseId);

        $enrolledAt = now();
        $syncData = $selectedCourseIds->mapWithKeys(
            fn (int $courseId) => [
                $courseId => $currentCourseIds->contains($courseId)
                    ? []
                    : ['enrolled_at' => $enrolledAt],
            ],
        );

        $student->courses()->sync($syncData->all());

        return redirect()
            ->route('student.show', $student)
            ->with('success', 'Student courses updated successfully.');
    }
}
