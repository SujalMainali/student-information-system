@extends('layouts.app')

@section('title', 'Edit Student · Manage')

@section('content')
    <div class="mx-auto max-w-2xl">
        @if($isAdmin)
            <a href="{{ route('student.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">&larr; Back to students</a>
        @else
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">&larr; Back to dashboard</a>    
        @endif

        <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex justify-center sm:justify-start">
                <x-student-avatar :image="$student->user?->image?->image_path" size="lg" />
            </div>

            <div class="border-b border-slate-100 pb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-600">Student #{{ $student->id }}</p>
                <div class="mt-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-950">Edit student</h1>
                    @if($isAdmin)
                        <a href="{{ route('student.courses', $student) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">
                            Manage courses
                        </a>
                    @endif
                </div>
                <p class="mt-2 text-sm leading-6 text-slate-600">Keep this learner's profile accurate and current.</p>
            </div>

            <form action="{{ route('student.update', $student) }}" method="POST" enctype="multipart/form-data" class="pt-7">
                @include('students._form')
            </form>

            <form
                id="delete-student-form"
                action="{{ route('student.archieve', $student) }}"
                method="POST"
                onsubmit="return confirm('Delete this student? This action cannot be undone.')"
            >
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection
