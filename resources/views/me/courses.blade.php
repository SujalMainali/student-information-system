@extends('layouts.app')

@section('title', 'My Courses | Manage')

@section('content')
    @php
        $courseItems = $courses ?? collect();
        $displayCourses = is_object($courseItems) && method_exists($courseItems, 'items')
            ? collect($courseItems->items())
            : collect($courseItems);
        $statCourses = is_object($courseItems) && method_exists($courseItems, 'getCollection')
            ? $courseItems->getCollection()
            : $displayCourses;

        $totalCredits = $totalCredits ?? $statCourses->sum('credits');
        $courseCount = $courseCount ?? $statCourses->count();
        $averageCredits = $averageCredits ?? ($courseCount > 0 ? round($totalCredits / $courseCount, 1) : 0);
        $pendingRequests = $pendingRequests ?? 1;
    @endphp

    <div class="mx-auto max-w-7xl space-y-8">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900">&larr; Dashboard</a>
                <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">My Courses</h1>
                <p class="mt-2 text-slate-600">Browse the courses you're currently enrolled in.</p>
            </div>
        </header>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard.stat-card label="Total Credits" :value="$totalCredits" tone="indigo" />
            <x-dashboard.stat-card label="Enrolled Courses" :value="$courseCount" tone="emerald" />
            <x-dashboard.stat-card label="Average Credits" :value="$averageCredits" tone="sky" />
            <x-dashboard.stat-card label="Pending Requests" :value="$pendingRequests" tone="amber" />
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-950">Filters</h2>

            <form method="GET" class="mt-5 grid gap-4 md:grid-cols-[minmax(0,1fr)_220px_220px]">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Search</span>
                    <input
                        type="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search course"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-300 focus:bg-white focus:ring-4 focus:ring-indigo-100"
                    >
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Semester</span>
                    <select
                        name="semester"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 outline-none transition focus:border-indigo-300 focus:bg-white focus:ring-4 focus:ring-indigo-100"
                    >
                        <option>All Semesters</option>
                        <option>Fall 2026</option>
                        <option>Spring 2026</option>
                    </select>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-700">Sort</span>
                    <select
                        name="sort"
                        class="mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 outline-none transition focus:border-indigo-300 focus:bg-white focus:ring-4 focus:ring-indigo-100"
                    >
                        <option>Newest</option>
                        <option>Credits</option>
                        <option>Alphabetical</option>
                    </select>
                </label>
            </form>
        </section>

        <section>
            <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-950">Course Cards</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $courseCount }} {{ Str::plural('course', $courseCount) }} in your current enrollment list.</p>
                </div>
            </div>

            <div class="mt-5">
                @if ($displayCourses->isEmpty())
                    <x-course.empty-state />
                @else
                    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                        @foreach ($displayCourses as $course)
                            <x-course.course-card :course="$course" />
                        @endforeach
                    </div>

                    @if (is_object($courseItems) && method_exists($courseItems, 'hasPages') && $courseItems->hasPages())
                        <div class="mt-8">
                            {{ $courseItems->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </section>
    </div>
@endsection
