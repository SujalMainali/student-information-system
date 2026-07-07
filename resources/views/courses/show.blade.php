@extends('layouts.app')

@section('title', $course->name.' · Manage')

@section('content')
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('course.index') }}" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900">&larr; Back to courses</a>

        <section class="mt-6 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="relative overflow-hidden bg-slate-950 px-6 py-10 text-white sm:px-10">
                <div class="absolute -right-20 -top-20 size-72 rounded-full bg-indigo-500/20 blur-3xl"></div>

                <div class="relative flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-300">Course #{{ $course->id }}</p>
                        <h1 class="mt-3 text-4xl font-bold tracking-tight sm:text-5xl">{{ $course->name }}</h1>
                        <div class="mt-5 flex flex-wrap gap-3 text-sm">
                            <span class="rounded-full border border-white/10 bg-white/10 px-3 py-1.5 font-semibold">
                                {{ $course->credits }} {{ Str::plural('credit', $course->credits) }}
                            </span>
                            <span class="rounded-full border border-white/10 bg-white/10 px-3 py-1.5 text-slate-300">
                                Created {{ $course->created_at->format('M j, Y') }}
                            </span>
                        </div>
                    </div>
                    @if($isAdmin)
                        <a href="{{ route('course.edit', $course) }}" class="inline-flex shrink-0 items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-slate-100">
                            Edit course
                        </a>
                    @endif
                </div>
            </div>

            <div class="space-y-10 p-6 sm:p-10">
                <section>
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Resources</p>
                            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Course documents</h2>
                        </div>
                        <span class="text-sm font-medium text-slate-500">
                            {{ $course->courseDocuments->count() }} {{ Str::plural('document', $course->courseDocuments->count()) }}
                        </span>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse ($course->courseDocuments as $document)
                            <details class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50/60 open:border-indigo-200 open:bg-indigo-50/40">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-4 marker:hidden">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200">
                                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5l-5.25-5.25Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 2.25V7.5h5.25"/>
                                            </svg>
                                        </span>
                                        <span class="min-w-0">
                                            <span class="block truncate font-semibold text-slate-900">{{ $document->original_name }}</span>
                                            <span class="mt-0.5 block text-xs uppercase tracking-wide text-slate-400">
                                                {{ strtoupper(pathinfo($document->original_name, PATHINFO_EXTENSION)) ?: 'File' }}
                                            </span>
                                        </span>
                                    </div>

                                    <svg class="size-5 shrink-0 text-slate-400 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.22 7.72a.75.75 0 0 1 1.06 0L10 11.44l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.78a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/>
                                    </svg>
                                </summary>

                                <div class="border-t border-indigo-100 px-4 py-4 sm:flex sm:items-center sm:justify-between">
                                    <div class="text-sm text-slate-500">
                                        <p>Uploaded {{ $document->created_at->format('M j, Y') }}</p>
                                        <p class="mt-1 truncate">{{ $document->path }}</p>
                                    </div>

                                    <a
                                        href="{{ Storage::disk('public')->url($document->path) }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="mt-4 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 sm:mt-0"
                                    >
                                        Open document
                                    </a>
                                </div>
                            </details>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-12 text-center">
                                <p class="font-semibold text-slate-900">No documents uploaded</p>
                                <p class="mt-2 text-sm text-slate-500">Documents added to this course will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="border-t border-slate-100 pt-10">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Enrollment</p>
                            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">Enrolled students</h2>
                        </div>
                        <span class="rounded-full bg-indigo-50 px-3 py-1 text-sm font-semibold text-indigo-700">
                            {{ $students->total() }} {{ Str::plural('student', $students->total()) }}
                        </span>
                    </div>

                    <div class="mt-5 space-y-3">
                        @forelse ($students as $student)
                            <x-enrolled-student-item :student="$student" :hasAccess="$isAdmin || $isStaff"/>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 px-6 py-12 text-center">
                                <p class="font-semibold text-slate-900">No students enrolled</p>
                                <p class="mt-2 text-sm text-slate-500">Students assigned to this course will appear here.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($students->hasPages())
                        <div class="mt-8">
                            {{ $students->links() }}
                        </div>
                    @endif
                </section>
            </div>
        </section>
    </div>
@endsection
