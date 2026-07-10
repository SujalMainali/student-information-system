@extends('layouts.app')

@section('title', 'Notification')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    <a
        href="{{ route('notification.index') }}"
        class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition hover:text-indigo-700"
    >
        ← Back to notifications
    </a>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        @php
            $title = $notification->data['title'] ?? 'Notification';
            $message = $notification->data['message'] ?? '';
            $url = $notification->data['url'] ?? null;
            $unread = is_null($notification->read_at);
        @endphp

        <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl {{ $unread ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2a6 6 0 00-6 6v3.1c0 .8-.2 1.6-.6 2.3L4.2 16a1 1 0 00.9 1.5h13.8a1 1 0 00.9-1.5l-1.2-2.6c-.4-.7-.6-1.5-.6-2.3V8a6 6 0 00-6-6zm0 20a2.5 2.5 0 002.4-1.8h-4.8A2.5 2.5 0 0012 22z"/>
                    </svg>
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-2xl font-bold tracking-tight text-slate-950">
                            {{ $title }}
                        </h1>

                        @if($unread)
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-inset ring-indigo-200">
                                Unread
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                Read
                            </span>
                        @endif
                    </div>

                    <p class="mt-2 text-sm text-slate-500">
                        Received {{ $notification->created_at?->diffForHumans() }}
                    </p>
                </div>
            </div>

            <div class="text-sm text-slate-500">
                {{ $notification->created_at?->format('M d, Y • h:i A') }}
            </div>
        </div>

        <div class="mt-8 rounded-2xl bg-slate-50 p-6">
            <p class="text-base leading-8 text-slate-700">
                {{ $message }}
            </p>
        </div>

        <div class="mt-8 flex flex-wrap items-center justify-end gap-3">
            @if($url)
                <a
                    href="{{ $url }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700"
                >
                    View related item
                </a>
            @endif

            @if($unread)
                <form method="POST" action="{{ route('notification.read', $notification) }}">
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100"
                    >
                        Mark as read
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection