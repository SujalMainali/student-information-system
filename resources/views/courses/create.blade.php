@extends('layouts.app')

@section('title', 'Create Course · Manage')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('course.index') }}" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900">&larr; Back to courses</a>

        <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-indigo-600">New record</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Create a course</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">Add the name and credit value. You can edit both later.</p>
            </div>

            <form action="{{ route('course.store') }}" method="POST" class="pt-7">
                @include('courses._form', ['course' => new \App\Models\Course()])
            </form>
        </div>
    </div>
@endsection
