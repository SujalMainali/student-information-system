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
            <x-dashboard.stat-card label="Students" :value="$totalStudents" tone="indigo" />
            <x-dashboard.stat-card label="Courses" :value="$totalCourses" tone="emerald" />
            <x-dashboard.stat-card label="Enrollments" :value="$totalEnrollments" tone="amber" />
        @endif

        @if($isStudent)
            <x-dashboard.stat-card label="Enrolled Courses" :value="$enrolledCourses" tone="indigo" />
            <x-dashboard.stat-card label="Current Credits" :value="$currentCredits" tone="emerald" />
            <x-dashboard.stat-card label="Upcoming Classes" :value="$upcomingClasses" tone="sky" />
            <x-dashboard.stat-card label="Upcoming Exams" :value="$upcomingExams" tone="rose" />
            <x-dashboard.stat-card label="Pending Requests" :value="$pendingRequests" tone="amber" />
        @endif
    </section>

    {{-- Quick Actions --}}
    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <h2 class="text-lg font-semibold text-slate-900">Quick Actions</h2>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @if($isStudent)
                <x-dashboard.action-link label="Browse Courses" href="/courses" variant="indigo" />
                <x-dashboard.action-link label="My Courses" href="/me/courses" variant="slate" />
                <x-dashboard.action-link label="Request Enrollment" href="#" variant="emerald" />
                <x-dashboard.action-link label="View Timetable" href="#" variant="sky" />
                <x-dashboard.action-link label="View Results" href="#" variant="slate" />
            @endif

            @if($isAdmin || $isStaff)
                <x-dashboard.action-link label="Manage System" href="{{ url('/manage') }}" variant="primary" />
            @endif
        </div>
    </section>

</div>
@endsection
