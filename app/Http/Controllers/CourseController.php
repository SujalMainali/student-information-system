<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\Course\CreateRequest;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Jobs\SendEnrollNotifications;

class CourseController extends Controller
{
    private const PAGE_SIZE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $isAdmin = auth()->user()->isAdmin();

        $courses = Course::query()
            ->select(['id', 'name', 'credits'])
            ->orderBy('id')
            ->paginate(self::PAGE_SIZE);

        if ($courses->currentPage() > $courses->lastPage()) {
            return redirect()->route('course.index');
        }

        if(request()->expectsJson()) {
            // return response()->json([
            //     'message' => 'Courses retrieved successfully.',
            //     'data' => $courses,
            // ], 200);
            return CourseResource::collection($courses)
                ->additional([
                    'message' => 'Courses retrieved successfully.',
                ]);
        }
        return view('courses.index', compact('courses','isAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $validated = $request->validated();

        $course = DB::transaction(function () use ($validated, $request) {
            $course = Course::create([
                'name' => $validated['name'],
                'credits' => $validated['credits'],
            ]);

            if ($request->hasFile('documents')) {
                $documents = collect($request->file('documents'))
                    ->map(function ($document) {
                        return [
                            'path' => $document->store('course_documents', 'public'),
                            'original_name' => $document->getClientOriginalName(),
                        ];
                    });

                $course->courseDocuments()->createMany($documents->all());
            }

            return $course;
        });

        if($request->expectsJson()) {
            return response()->json([
                'message' => 'Course created successfully.',
                'data' => new CourseResource($course->load('courseDocuments')),
            ], 201);
        }

        return redirect()
            ->route('course.show', $course)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $course)
    {
        $isAdmin = auth()->user()->isAdmin();
        $isStaff = auth()->user()->isStaff();
        $course = Course::query()
            ->select([
                'id',
                'name',
                'credits',
                'created_at',
            ])
            ->with([
                'courseDocuments' => fn ($query) => $query
                    ->select([
                        'id',
                        'course_id',
                        'path',
                        'original_name',
                        'created_at',
                    ])
                    ->orderBy('original_name'),
            ])
            ->findOrFail($course);

        $students = $course->students()
            ->select([
                'students.id',
                'students.name',
            ])
            ->orderBy('students.name')
            ->paginate(self::PAGE_SIZE, pageName: 'students_page');

        if ($students->currentPage() > $students->lastPage()) {
            return redirect()->route('course.show', $course);
        }

        if(request()->expectsJson()) {
            return response()->json([
                'message' => 'Course retrieved sucessfully.',
                'data' => new CourseResource($course),
            ], 200);                
        }

        return view('courses.show', compact('course', 'students','isAdmin','isStaff'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRequest $request, Course $course)
    {
        $validated = $request->validated();

        $course = DB::transaction(function () use ($validated, $request, $course) {
            $course->update([
                'name' => $validated['name'],
                'credits' => $validated['credits'],
            ]);

            if ($request->hasFile('documents')) {
                $documents = collect($request->file('documents'))
                    ->map(function ($document) {
                        return [
                            'path' => $document->store('course_documents', 'public'),
                            'original_name' => $document->getClientOriginalName(),
                        ];
                    });

                $course->courseDocuments()->createMany($documents->all());
            }

            return $course;
        });

        if($request->expectsJson()) {
            return response()->json([
                'message' => 'Course updated successfully.',
                'data' => new CourseResource($course->load('courseDocuments')),
            ], 200);
        }

        return redirect()
            ->route('course.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {

        DB::transaction(function () use ($course) {
            // Delete the associated course documents if they exist
            if ($course->courseDocuments()->exists()) {
                foreach ($course->courseDocuments as $document) {
                    Storage::disk('public')->delete($document->path);
                }
            }
            $course->delete();
        });

        if(request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()
            ->route('course.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function enroll(Course $course)
    {
        $user = auth()->user();

        $user_courses = $user->student->courses()->pluck('courses.id')->toArray();

        if (in_array($course->id, $user_courses)) {
            if(request()->expectsJson()) {
                return response()->json([
                    'message' => 'You are already enrolled in this course.',
                ], 400);
            }

            return redirect()
                ->route('course.show', $course)
                ->with('error', 'You are already enrolled in this course.');
        }

        $enrollRequest = $user->student->enrollmentRequests()->create([
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        SendEnrollNotifications::dispatch($enrollRequest);

        if(request()->expectsJson()) {
            return response()->json([
                'message' => 'Enrollment Request sent successfully.',
            ], 200);
        }

        return redirect()
            ->route('course.show', $course)
            ->with('success', 'Enrollment Request sent successfully.');
    }
}
