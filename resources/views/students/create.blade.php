@extends('layouts.app')

@section('title', 'Create Student · Manage')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('student.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">&larr; Back to students</a>

        <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="border-b border-slate-100 pb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-600">New record</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">Register a student</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">Add their essential details to the student directory.</p>
            </div>

            <form action="{{ route('student.store') }}" method="POST" class="pt-7">
                @include('students._form', ['student' => new \App\Models\Student()])
            </form>
        </div>
    </div>
@endsection
