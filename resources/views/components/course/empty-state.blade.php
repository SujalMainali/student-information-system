@props([
    'title' => "You haven't enrolled in any courses yet.",
    'message' => 'Browse available courses and request enrollment when you are ready.',
])

<div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
        <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 5.25A2.25 2.25 0 0 1 6.75 3h10.5a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 17.25 21H6.75a2.25 2.25 0 0 1-2.25-2.25V5.25Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7.5h8M8 11.25h8M8 15h5"/>
        </svg>
    </div>

    <h2 class="mt-5 text-lg font-semibold text-slate-950">{{ $title }}</h2>
    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">{{ $message }}</p>
</div>
