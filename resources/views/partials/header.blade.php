<header class="border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-3" aria-label="Manage home">
            <span class="grid size-11 place-items-center overflow-hidden rounded-2xl bg-indigo-50 ring-1 ring-indigo-100 transition group-hover:-rotate-3">
                <img src="{{ asset('blackboard.png') }}" alt="" class="size-7">
            </span>
            <span>
                <span class="block text-lg font-bold tracking-tight text-slate-950">Blackboard</span>
                <span class="block text-xs font-medium text-slate-500">Learning made orderly</span>
            </span>
        </a>
        <div class="flex items-center gap-3">
            @auth

                <x-notifications.bell
                    :notifications="$notifications ?? []"
                    :unread-count="$unreadCount ?? 0"
                    :view-all-url="route('notification.index')"
                />

                <div class="hidden rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm sm:block">
                    {{ auth()->user()->name }}
                </div>

                <a
                    href="{{ route('me.show') }}"
                    class="inline-flex items-center gap-2 rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700"
                >
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.118a7.5 7.5 0 0 1 15 0A17.933 17.933 0 0 1 12 21.75a17.933 17.933 0 0 1-7.5-1.632Z"/>
                    </svg>

                    <span class="hidden sm:inline">Me</span>
                </a>

                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-sm font-bold text-rose-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-rose-100"
                    >
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 15l3-3m0 0-3-3m3 3H9"/>
                        </svg>

                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</header>
