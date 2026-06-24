<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CreateRequest;
use App\Models\Course;

class CourseController extends Controller
{
    private const PAGE_SIZE = 5;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::query()
            ->select(['id', 'name', 'credits'])
            ->orderBy('id')
            ->paginate(self::PAGE_SIZE);

        if ($courses->currentPage() > $courses->lastPage()) {
            return redirect()->route('course.index');
        }

        return view('courses.index', compact('courses'));
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
        Course::create($request->validated());

        return redirect()
            ->route('course.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
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
        $course->update($request->validated());

        return redirect()
            ->route('course.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()
            ->route('course.index')
            ->with('success', 'Course deleted successfully.');
    }
}
