@props([
    'course',
    'isAdmin' => false,
    'showEnroll' => false,
])

<article class="group flex flex-col gap-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md sm:flex-row sm:items-center sm:justify-between">
    <div class="min-w-0">
        <h2 class="truncate text-base font-semibold text-slate-950">
            <a href="{{ route('course.show', $course) }}" class="transition hover:text-amber-700">{{ $course->name }}</a>
        </h2>

        <p class="mt-1 truncate text-sm text-slate-500">Course #{{ $course->id }}</p>

        <div class="mt-3 flex flex-wrap items-center gap-2">
            <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700">
                {{ $course->credits }} {{ Str::plural('credit', $course->credits) }}
            </span>
        </div>
    </div>

    <div class="flex shrink-0 flex-wrap gap-2">
        <a href="{{ route('course.show', $course) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-700 transition hover:bg-amber-100">
            View
        </a>

        @if ($showEnroll)
            <form action="{{ url('/courses/'.$course->id.'/enroll') }}" method="POST">
                @csrf

                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    Request Enroll
                </button>
            </form>
        @endif

        @if ($isAdmin)
            <a href="{{ route('course.edit', $course) }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-700">
                Edit
                <svg class="size-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m13.5 3.5 3 3m-11 10 3.2-.7 7.55-7.55a1.414 1.414 0 0 0 0-2l-2.5-2.5a1.414 1.414 0 0 0-2 0L4.2 11.3l-.7 3.2v2h2Z"/>
                </svg>
            </a>
        @endif
    </div>
</article>
