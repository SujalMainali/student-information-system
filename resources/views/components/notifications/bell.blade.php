@props([
    'notifications' => collect(),
    'unreadCount' => 0,
    'viewAllUrl' => '#',
])

<div
    x-data="{ open: false }"
    class="relative"
>
    <button
        type="button"
        @click="open = !open"
        @click.outside="open = false"
        class="relative inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900"
        aria-label="Notifications"
    >
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12 2a6 6 0 00-6 6v3.1c0 .8-.2 1.6-.6 2.3L4.2 16a1 1 0 00.9 1.5h13.8a1 1 0 00.9-1.5l-1.2-2.6c-.4-.7-.6-1.5-.6-2.3V8a6 6 0 00-6-6zm0 20a2.5 2.5 0 002.4-1.8h-4.8A2.5 2.5 0 0012 22z"/>
        </svg>

        @if($unreadCount > 0)
            <span class="absolute -right-1 -top-1 inline-flex min-w-5 items-center justify-center rounded-full bg-rose-600 px-1.5 py-0.5 text-[11px] font-bold text-white">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" x-transition class="absolute right-0 top-full mt-3 w-[22rem]" style="display: none;">
        <x-notifications.dropdown
            :notifications="$notifications"
            :view-all-url="$viewAllUrl"
        />
    </div>
</div>