@extends('layouts.app')

@section('title', 'Edit Course · Manage')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('course.index') }}" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900">&larr; Back to courses</a>

        <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">Course #{{ $course->id }}</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Edit course</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">Update the details below and save when you are ready.</p>
            </div>

            <form action="{{ route('course.update', $course) }}" method="POST" class="pt-7">
                @include('courses._form')
            </form>

            <form
                id="delete-course-form"
                action="{{ route('course.destroy', $course) }}"
                method="POST"
                onsubmit="return confirm('Delete this course? This action cannot be undone.')"
            >
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection
