<?php

namespace App\Services;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Http\Requests\Course\CreateRequest;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseService
{
    private const PAGE_SIZE = 5;

    /**
     * @param array{
     *     name: string,
     *     credits: int,
     *    documents?: array<\Illuminate\Http\UploadedFile>
     * } $validatedData
     */

    public function index() : LengthAwarePaginator
    {
        $courses = Course::query()
            ->select(['id', 'name', 'credits'])
            ->orderBy('id')
            ->paginate(self::PAGE_SIZE);
        
        return $courses;
    }

    public function create(array $validatedData, CreateRequest $request) : Course
    {
        $course = DB::transaction(function () use ($validatedData, $request) {
            $course = Course::create([
                'name' => $validatedData['name'],
                'credits' => $validatedData['credits'],
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
    return $course;
    
    }

    public function show(int $course) : array
    {
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
                    ->orderBy('original_name')
            ])
            ->findOrFail($course);

        $students = $course->students()
            ->select([
                'students.id',
                'students.name',
            ])
            ->orderBy('students.name')
            ->paginate(self::PAGE_SIZE, pageName: 'students_page');

        return [$course,$students];
    }

    public function update(array $validatedData, CreateRequest $request, Course $course) : Course
    {
        $course = DB::transaction(function () use ($validatedData, $request, $course) {
            $course->update([
                'name' => $validatedData['name'],
                'credits' => $validatedData['credits'],
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

        return $course;
    }

    public function destroy(Course $course) : void
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
    }
}