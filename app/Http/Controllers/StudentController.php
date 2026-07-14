<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Student;
use App\Http\Resources\StudentResource;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            ->with('user')
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

        $student = DB::transaction(function () use ($validatedData, $request) {
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

            return $student;
        });

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
            'user'
        ]);
        Log::info('Student retrieved: ' . $student->id . 'image URL: ' . $student->avatar_url);
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
        Gate::authorize('update', $student);
        $isAdmin = auth()->user()->isAdmin();
        return view('students.edit', compact('student','isAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRequest $request, Student $student)
    {
        Gate::authorize('update', $student);
        $validatedData = $request->validated();

        $student = DB::transaction(function () use ($validatedData, $request, $student) {
            $student->update($validatedData);

            // Use dynamic properties ($student->user) to avoid redundant database queries
            $user = $student->user;

            if ($user && $request->hasFile('profile_image')) {
                
                // Load the image relationship once
                $oldImage = $user->image; 

                // If an old file exists on the disk, delete it
                if ($oldImage && Storage::disk('public')->exists($oldImage->image_path)) {
                    Storage::disk('public')->delete($oldImage->image_path);
                }

                // Store the new file
                $newPath = $request->file('profile_image')->store('profile_images', 'public');

                // Update the path in the DB or create a new row if it didn't exist
                $user->image()->updateOrCreate(
                    [], // Empty array means "match anything associated to this user"
                    ['image_path' => $newPath]
                );
            }

            return $student;
        });

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
        DB::transaction(function () use ($student) {
            $student->user->roles()->detach(); // Detach all roles associated with the user
            $student->delete();
        });

        if(request()->expectsJson()) {
            return response()->noContent();
        }
            
        return redirect()
            ->route('student.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function forceDestroy(Student $student)
    {
        Log::info('Force deleting student with ID: ' . $student->id);
        DB::transaction(function () use ($student) {
            if ($student->profile_image) {
                Storage::disk('public')->delete($student->profile_image);
            }
            $student->forceDelete();
        });

        if(request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()
            ->route('dashboard')
            ->with('success', 'Student permanently deleted successfully.');
    }

    public function restore(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->restore();
            $student->user->assignRole('student'); // Reassign the "student" role to the user
        });

        if(request()->expectsJson()) {
            return response()->json([
                'message' => 'Student restored successfully.',
                'data' => new StudentResource($student),
            ], 200);
        }

        return redirect()
            ->route('student.show', $student)
            ->with('success', 'Student restored successfully.');
    }

    public function trashed()
    {
        $trashedStudents = Student::onlyTrashed()
            ->select(['id', 'name', 'email', 'dob'])
            ->orderBy('id')
            ->with([
                'user' => fn ($query) => $query
                    ->select('id', 'name', 'email')
                    ->with(['image' => fn ($query) => $query->select('id', 'image_path', 'imageable_id')]),
            ])
            ->paginate(self::PAGE_SIZE);

        if ($trashedStudents->currentPage() > $trashedStudents->lastPage()) {
            return redirect()->route('student.trashed');
        }

        if(request()->expectsJson()) {
            return response()->json([
                'message' => 'Trashed students retrieved successfully.',
                'data' => StudentResource::collection($trashedStudents),
            ], 200);
        }

        return view('students.trashed', ['trashedStudents' => $trashedStudents]);
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
