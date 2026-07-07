@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Welcome Header --}}
    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    {{ $greeting }}, {{ $userName }} 👋
                </p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    Welcome back to the Student Information System
                </h1>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                {{ $roleLabel }}
            </span>
        </div>
    </section>

    {{-- Summary Cards --}}
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @if($isAdmin || $isStaff)
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Students</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalStudents }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Courses</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalCourses }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Enrollments</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $totalEnrollments }}</p>
            </div>
        @endif

        @if($isStudent)
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Enrolled Courses</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $enrolledCourses }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Current Credits</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $currentCredits }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Upcoming Classes</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $upcomingClasses }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Upcoming Exams</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $upcomingExams }}</p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Pending Requests</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $pendingRequests }}</p>
            </div>
        @endif
    </section>

    {{-- Quick Actions --}}
    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-lg font-semibold text-slate-900">Quick Actions</h2>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @if($isStudent)
                <a href="#"
                   class="inline-flex items-center justify-center rounded-2xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-100">
                    Browse Courses
                </a>

                <a href="#"
                   class="inline-flex items-center justify-center rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-100">
                    Request Enrollment
                </a>

                <a href="#"
                   class="inline-flex items-center justify-center rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700 transition hover:bg-sky-100">
                    View Timetable
                </a>

                <a href="#"
                   class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">
                    View Results
                </a>
            @endif

            @if($isAdmin || $isStaff)
                <a href="{{ url('/manage') }}"
                   class="inline-flex items-center justify-center rounded-2xl border border-indigo-600 bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Manage System
                </a>
            @endif
        </div>
    </section>

</div>
@endsection