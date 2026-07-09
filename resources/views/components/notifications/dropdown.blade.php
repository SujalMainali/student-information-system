@props([
    'notifications' => collect(),
    'viewAllUrl' => '#',
])

@php
    $items = collect($notifications)->take(4);
@endphp

<div class="absolute right-0 z-50 mt-3 w-[22rem] overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl shadow-slate-200/70">
    <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
        <div>
            <h3 class="text-sm font-semibold text-slate-900">Notifications</h3>
            <p class="mt-0.5 text-xs text-slate-500">
                Latest updates and alerts
            </p>
        </div>
    </div>

    <div class="max-h-[24rem] overflow-y-auto p-3">
        @forelse($items as $notification)
            <x-notifications.item
                :id="$notification['id'] ?? null"
                :title="$notification['title'] ?? 'Notification'"
                :message="$notification['message'] ?? ''"
                :time="$notification['time'] ?? 'just now'"
                :unread="$notification['unread'] ?? false"
            />
        @empty
            <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-8 text-center">
                <p class="text-sm font-medium text-slate-600">No notifications yet</p>
                <p class="mt-1 text-xs text-slate-500">
                    New updates will appear here.
                </p>
            </div>
        @endforelse
    </div>

    <div class="border-t border-slate-200 p-3">
        <a href="{{ $viewAllUrl }}"
           class="flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            View all
        </a>
    </div>
</div>