@extends('layouts.app')

@section('title', 'Edit Student · Manage')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('student.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">&larr; Back to students</a>

        <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-600">Student #{{ $student->id }}</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Edit student</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">Keep this learner's profile accurate and current.</p>
            </div>

            <form action="{{ route('student.update', $student) }}" method="POST" class="pt-7">
                @include('students._form')
            </form>
        </div>
    </div>
@endsection
