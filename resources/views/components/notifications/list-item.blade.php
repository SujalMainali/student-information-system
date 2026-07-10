@props([
    'notification',
])

@php
    $title = $notification->data['title'] ?? 'Notification';
    $message = $notification->data['message'] ?? '';
    $url = $notification->data['url'] ?? route('notification.show', $notification);
    $time = $notification->created_at?->diffForHumans() ?? '';
    $unread = is_null($notification->read_at);
@endphp

<div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md {{ $unread ? 'ring-1 ring-indigo-100' : '' }}">
    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
        <div class="flex min-w-0 gap-4">
            <div class="mt-1 flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $unread ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2a6 6 0 00-6 6v3.1c0 .8-.2 1.6-.6 2.3L4.2 16a1 1 0 00.9 1.5h13.8a1 1 0 00.9-1.5l-1.2-2.6c-.4-.7-.6-1.5-.6-2.3V8a6 6 0 00-6-6zm0 20a2.5 2.5 0 002.4-1.8h-4.8A2.5 2.5 0 0012 22z"/>
                </svg>
            </div>

            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-lg font-semibold text-slate-900">
                        {{ $title }}
                    </h3>

                    @if($unread)
                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                            New
                        </span>
                    @endif
                </div>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    {{ $message }}
                </p>

                <div class="mt-4 flex flex-wrap items-center gap-4 text-xs font-medium text-slate-500">
                    <span>{{ $time }}</span>

                    @if(isset($notification->data['type']))
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-slate-600">
                            {{ $notification->data['type'] }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex shrink-0 flex-wrap items-center gap-2 sm:justify-end">
            <a
                href="{{ route('notification.show', $notification) }}"
                class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
            >
                View
            </a>

            @if($unread)
                <form method="POST" action="{{ route('notification.read', $notification) }}">
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Mark as read
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>