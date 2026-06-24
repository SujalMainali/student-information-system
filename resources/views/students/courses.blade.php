@extends('layouts.app')

@section('title', 'Student Courses · Manage')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('student.edit', $student) }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">&larr; Back to student</a>

        <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-600">Course enrollment</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">{{ $student->name }}</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">Select every course this student should be enrolled in, then save the checklist.</p>
            </div>

            <form action="{{ route('student.courses.update', $student) }}" method="POST" class="pt-7">
                @csrf
                @method('PATCH')

                @error('courses')
                    <p class="mb-4 rounded-xl bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">{{ $message }}</p>
                @enderror

                @php
                    $selectedCourseIds = collect(old('courses', $enrolledCourseIds))
                        ->map(fn ($courseId) => (int) $courseId);
                @endphp

                <div class="grid gap-3 sm:grid-cols-2">
                    @forelse ($courses as $course)
                        <x-course-checklist-item
                            :course="$course"
                            :checked="$selectedCourseIds->contains($course->id)"
                        />
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-slate-300 px-6 py-12 text-center">
                            <p class="font-semibold text-slate-900">No courses are available</p>
                            <p class="mt-2 text-sm text-slate-500">Create a course before assigning enrollments.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('student.edit', $student) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-amber-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-amber-200 transition hover:bg-amber-600">
                        Save enrollments
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
