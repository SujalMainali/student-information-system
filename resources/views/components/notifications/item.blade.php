@props([
    'id' => null,
    'title' => 'Notification title',
    'message' => 'Notification message',
    'href' => '#',
    'time' => 'just now',
    'unread' => false,
    'icon' => 'M15.59 14.37a6 6 0 10-7.18 0l-.59 3.13A1 1 0 009 19h6a1 1 0 00.98-1.5l-.39-3.13z',
])

@php
    $baseClasses = $unread
        ? 'bg-slate-100/90 hover:bg-slate-200'
        : 'bg-white hover:bg-slate-50';
@endphp

<div class="rounded-2xl border border-slate-200 p-4 transition {{ $baseClasses }}">
    <div class="flex gap-3">
        <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $unread ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="{{ $icon }}" />
            </svg>
        </div>

        <div class="min-w-0 flex-1">
            <div class="flex items-start justify-between gap-3">
                <p class="text-sm font-semibold text-slate-900">
                    {{ $title }}
                </p>

                <span class="shrink-0 text-xs font-medium text-slate-500">
                    {{ $time }}
                </span>
            </div>

            <p class="mt-1 text-sm leading-6 text-slate-600">
                {{ $message }}
            </p>

            <div class="mt-4 flex items-center justify-end gap-2 border-t border-slate-200 pt-3">

                <a
                    href="{{ route('notification.show', $id) }}"
                    class="inline-flex items-center rounded-xl bg-indigo-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-indigo-700"
                >
                    View
                </a>

                @if($unread)
                    <form
                        method="POST"
                        action="{{ route('notification.read', $id) }}"
                    >
                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-100"
                        >
                            Mark as read
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>