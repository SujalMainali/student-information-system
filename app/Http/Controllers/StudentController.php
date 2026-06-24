<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Student;

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
            ->paginate(self::PAGE_SIZE);

        if ($students->currentPage() > $students->lastPage()) {
            return redirect()->route('student.index');
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
        Student::create($request->validated());

        return redirect()
            ->route('student.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateRequest $request, Student $student)
    {
        $student->update($request->validated());

        return redirect()
            ->route('student.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('student.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * Display the student's course enrollment checklist.
     */
    public function courses(Student $student)
    {
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
            ->route('student.index', $student)
            ->with('success', 'Student courses updated successfully.');
    }
}
