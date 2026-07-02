@extends('layouts.app')

@section('title', 'My profile | Manage')

@section('content')
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('manage') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">&larr; Back to Manage</a>

        <section class="mt-6 overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
            <div class="relative bg-slate-950 px-6 py-10 sm:px-10">
                <div class="absolute right-0 top-0 size-64 rounded-full bg-indigo-400/10 blur-3xl"></div>

                <div class="relative flex flex-col gap-7 sm:flex-row sm:items-center">
                    <div class="grid size-36 shrink-0 place-items-center overflow-hidden rounded-[2rem] border-4 border-white bg-slate-100 text-slate-400 shadow-md ring-1 ring-white/20">
                        @if ($user->image?->image_path)
                            <img
                                src="{{ Storage::disk('public')->url($user->image->image_path) }}"
                                alt="{{ $user->name }} profile image"
                                class="size-full object-cover"
                            >
                        @else
                            <svg class="size-3/5" viewBox="0 0 24 24" fill="currentColor" aria-label="No profile image">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.75 20.105a8.25 8.25 0 0 1 16.5 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5a18.683 18.683 0 0 1-7.813-1.7.75.75 0 0 1-.437-.695Z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                    </div>

                    <div class="min-w-0 text-white">
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-300">My account</p>
                        <h1 class="mt-3 truncate text-4xl font-bold tracking-tight">{{ $user->name }}</h1>
                        <p class="mt-2 break-all text-slate-300">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-8 p-6 sm:p-10 lg:grid-cols-[0.8fr_1.2fr]">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Account details</p>

                    <dl class="mt-5 divide-y divide-slate-100 rounded-2xl border border-slate-200">
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">User ID</dt>
                            <dd class="mt-1 font-medium text-slate-900">#{{ $user->id }}</dd>
                        </div>
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Name</dt>
                            <dd class="mt-1 font-medium text-slate-900">{{ $user->name }}</dd>
                        </div>
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email</dt>
                            <dd class="mt-1 break-all font-medium text-slate-900">{{ $user->email }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Profile info</p>

                    <dl class="mt-5 divide-y divide-slate-100 rounded-2xl border border-slate-200">
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Email verification</dt>
                            <dd class="mt-1 font-medium text-slate-900">
                                @if ($user->email_verified_at)
                                    Verified on {{ $user->email_verified_at->format('F j, Y') }}
                                @else
                                    Not verified
                                @endif
                            </dd>
                        </div>
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Joined</dt>
                            <dd class="mt-1 font-medium text-slate-900">{{ $user->created_at->format('F j, Y') }}</dd>
                        </div>
                        <div class="p-4">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Profile image</dt>
                            <dd class="mt-1 font-medium text-slate-900">
                                @if ($user->image)
                                    Uploaded {{ $user->image->created_at->format('F j, Y') }}
                                @else
                                    No profile image uploaded
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>
    </div>
@endsection
