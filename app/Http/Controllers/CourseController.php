<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CreateRequest;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use App\Jobs\SendEnrollNotifications;
use App\Services\CourseService;
use App\Exceptions\UserAlreadyEnrolledException;

class CourseController extends Controller
{
    public function __construct
    (
        private CourseService $courseService
    )
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $isAdmin = auth()->user()->isAdmin();

        $courses = $this->courseService->index();

        if ($courses->currentPage() > $courses->lastPage()) {
            return redirect()->route('course.index');
        }

        if(request()->expectsJson()) {
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
        $course = $this->courseService->create($validated, $request);
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
        
        [$course, $students] = $this->courseService->show($course);

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

        $course = $this->courseService->update($validated, $request, $course);

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
        $this->courseService->destroy($course);

        if(request()->expectsJson()) {
            return response()->noContent();
        }

        return redirect()
            ->route('course.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function enroll(Course $course)
    {
        $this->courseService->enroll($course);

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
