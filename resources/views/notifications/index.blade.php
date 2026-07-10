@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="mx-auto max-w-5xl space-y-8">

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-indigo-600">
                    Notifications
                </p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">
                    All notifications
                </h1>
                <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600">
                    View updates, requests, reminders, and system activity in one place.
                </p>
            </div>

            @if($pageNotifications->whereNull('read_at')->count() > 0)
                <form method="POST" action="{{ route('notification.read-all') }}">
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700"
                    >
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="space-y-4">
        @forelse($pageNotifications as $notification)
            <x-notifications.list-item :notification="$notification" />
        @empty
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2a6 6 0 00-6 6v3.1c0 .8-.2 1.6-.6 2.3L4.2 16a1 1 0 00.9 1.5h13.8a1 1 0 00.9-1.5l-1.2-2.6c-.4-.7-.6-1.5-.6-2.3V8a6 6 0 00-6-6zm0 20a2.5 2.5 0 002.4-1.8h-4.8A2.5 2.5 0 0012 22z"/>
                    </svg>
                </div>

                <h2 class="mt-6 text-xl font-bold text-slate-900">
                    No notifications yet
                </h2>
                <p class="mt-2 text-slate-500">
                    New updates will appear here when something happens.
                </p>
            </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $pageNotifications->onEachSide(1)->links() }}
    </div>

</div>
@endsection