<header class="border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('manage') }}" class="group flex items-center gap-3" aria-label="Manage home">
            <span class="grid size-11 place-items-center overflow-hidden rounded-2xl bg-indigo-50 ring-1 ring-indigo-100 transition group-hover:-rotate-3">
                <img src="{{ asset('admin.jpg') }}" alt="" class="size-7">
            </span>
            <span>
                <span class="block text-lg font-bold tracking-tight text-slate-950">Manage</span>
                <span class="block text-xs font-medium text-slate-500">Learning made orderly</span>
            </span>
        </a>

        <div class="grid size-11 place-items-center rounded-full border border-slate-200 bg-slate-50 text-slate-600 shadow-sm" aria-label="User profile">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z"/>
            </svg>
        </div>
    </div>
</header>
