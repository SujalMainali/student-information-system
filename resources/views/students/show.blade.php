@extends('layouts.app')

@section('title', $student->name.' · Manage')

@section('content')
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('student.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">&larr; Back to students</a>

        <section class="mt-6 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="relative bg-slate-950 px-6 py-10 sm:px-10">
                <div class="absolute right-0 top-0 size-64 rounded-full bg-amber-400/10 blur-3xl"></div>

                <div class="relative flex flex-col gap-7 sm:flex-row sm:items-center">
                    <x-student-avatar :student="$student" size="xl" class="ring-white/20" />

                    <div class="min-w-0 text-white">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-amber-300">Student #{{ $student->id }}</p>
                        <h1 class="mt-3 truncate text-4xl font-bold tracking-tight">{{ $student->name }}</h1>
                        <p class="mt-2 text-slate-300">{{ $student->email }}</p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('student.edit', $student) }}" class="rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">Edit profile</a>
                            <a href="{{ route('student.courses', $student) }}" class="rounded-xl border border-white/20 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20">Manage courses</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-8 p-6 sm:p-10 lg:grid-cols-[0.8fr_1.2fr]">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Student details</p>

                    <dl class="mt-5 divide-y divide-slate-100 rounded-2xl border border-slate-200">
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</dt>
                            <dd class="mt-1 break-all font-medium text-slate-900">{{ $student->email }}</dd>
                        </div>
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Date of birth</dt>
                            <dd class="mt-1 font-medium text-slate-900">
                                {{ $student->dob->format('F j, Y') }}
                                <span class="text-sm font-normal text-slate-500">({{ $student->dob->age }} years old)</span>
                            </dd>
                        </div>
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Joined</dt>
                            <dd class="mt-1 font-medium text-slate-900">{{ $student->created_at->format('F j, Y') }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Enrollments</p>
                            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Courses</h2>
                        </div>
                        <span class="rounded-full bg-amber-50 px-3 py-1 text-sm font-semibold text-amber-700">
                            {{ $student->courses->count() }} {{ Str::plural('course', $student->courses->count()) }}
                        </span>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse ($student->courses as $course)
                            <article class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 p-4">
                                <div class="min-w-0">
                                    <h3 class="truncate font-semibold text-slate-950">{{ $course->name }}</h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $course->credits }} {{ Str::plural('credit', $course->credits) }}
                                        @if ($course->pivot->enrolled_at)
                                            · Enrolled {{ \Illuminate\Support\Carbon::parse($course->pivot->enrolled_at)->format('M j, Y') }}
                                        @endif
                                    </p>
                                </div>
                                <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">#{{ $course->id }}</span>
                            </article>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-12 text-center">
                                <p class="font-semibold text-slate-900">No course enrollments</p>
                                <p class="mt-2 text-sm text-slate-500">This student has not been assigned to a course yet.</p>
                                <a href="{{ route('student.courses', $student) }}" class="mt-4 inline-flex text-sm font-semibold text-amber-700 hover:text-amber-900">Assign courses &rarr;</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
