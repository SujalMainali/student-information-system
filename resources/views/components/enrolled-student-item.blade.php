@props(['student','hasAccess' => false])

<article class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-indigo-200 hover:shadow-sm sm:flex-row sm:items-center sm:justify-between">
    <div class="min-w-0">
        <h3 class="truncate font-semibold text-slate-950">{{ $student->name }}</h3>
        <p class="mt-1 text-sm text-slate-500">Student #{{ $student->id }}</p>
    </div>

    @if($hasAccess)
        <a
            href="{{ route('student.show', $student) }}"
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-indigo-50 px-4 py-2.5 text-sm font-semibold text-indigo-700 transition hover:bg-indigo-100"
        >
            View
            <svg class="size-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 10s2.5-4.5 6.5-4.5 6.5 4.5 6.5 4.5-2.5 4.5-6.5 4.5S3.5 10 3.5 10Z"/>
                <circle cx="10" cy="10" r="1.75"/>
            </svg>
        </a>
    @endif
</article>
