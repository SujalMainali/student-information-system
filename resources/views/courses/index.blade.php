@extends('layouts.app')

@section('title', 'Courses · Manage')

@section('content')
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900">&larr; Dashboard</a>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">Courses</h1>
            <p class="mt-2 text-slate-600">Keep your course catalogue clear and up to date.</p>
        </div>

        @if($isAdmin)
            <a href="{{ route('course.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-700">
                <span class="text-lg leading-none">+</span>
                Add course
            </a>
        @endif
    </div>

    <div class="mt-8 space-y-3">
        @forelse ($courses as $course)
            <x-course.resource-list-item
                :course="$course"
                :is-admin="$isAdmin"
                :show-enroll="auth()->user()->isStudent()"
            />
        @empty
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <p class="text-lg font-semibold text-slate-900">No courses yet</p>
                <p class="mt-2 text-sm text-slate-500">Create your first course to get the catalogue started.</p>
            </div>
        @endforelse
    </div>

    @if ($courses->hasPages())
        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @endif
@endsection
