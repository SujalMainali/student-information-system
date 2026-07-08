@props([
    'course',
])

@php
    $courseCode = $course->code ?? 'COMP'.str_pad((string) ($course->id ?? 0), 4, '0', STR_PAD_LEFT);
    $courseName = $course->name ?? 'Untitled course';
    $credits = $course->credits ?? 3;
    $lecturer = $course->lecturer ?? $course->instructor ?? 'John Smith';
    $semester = $course->semester ?? 'Fall 2026';
    $imagePath = $course->image?->image_path ?? $course->image_path ?? null;
@endphp

<article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:border-indigo-200 hover:shadow-md">
    <div class="aspect-[16/9] overflow-hidden bg-slate-100">
        @if ($imagePath)
            <img
                src="{{ Storage::disk('public')->url($imagePath) }}"
                alt="{{ $courseName }} image"
                class="size-full object-cover transition duration-300 group-hover:scale-105"
            >
        @else
            <div class="flex size-full items-center justify-center bg-slate-900 text-slate-300">
                <span class="text-sm font-semibold uppercase tracking-[0.18em]">Course Image</span>
            </div>
        @endif
    </div>

    <div class="space-y-5 p-5">
        <div>
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-indigo-600">{{ $courseCode }}</p>
            <h2 class="mt-2 line-clamp-2 text-xl font-bold tracking-tight text-slate-950">{{ $courseName }}</h2>
        </div>

        <dl class="grid gap-3 text-sm">
            <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-3 py-2">
                <dt class="font-medium text-slate-500">Credits</dt>
                <dd class="font-semibold text-slate-950">{{ $credits }}</dd>
            </div>
            <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-3 py-2">
                <dt class="font-medium text-slate-500">Lecturer</dt>
                <dd class="truncate font-semibold text-slate-950">{{ $lecturer }}</dd>
            </div>
            <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-3 py-2">
                <dt class="font-medium text-slate-500">Semester</dt>
                <dd class="font-semibold text-slate-950">{{ $semester }}</dd>
            </div>
        </dl>

        <a
            href="{{ route('course.show', $course) }}"
            class="inline-flex w-full items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
        >
            View Details
        </a>
    </div>
</article>
