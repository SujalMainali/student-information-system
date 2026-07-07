@extends('layouts.app')

@section('title', 'Register')

@php
    $role = $role ?? 'student';
    $roleLabel = $roleLabel ?? match ($role) {
        'admin' => 'Administrator',
        'staff' => 'Staff',
        default => 'Student',
    };

    $submitRoute = match ($role) {
        'admin' => route('auth.admin.submit'),
        'staff' => route('auth.staff.submit'),
        default => route('auth.register.submit'),
    };

    $loginRoute = match ($role) {
        'admin' => route('auth.login'),
        'staff' => route('auth.login'),
        default => route('auth.login'),
    };

    $accentTone = match ($role) {
        'admin' => [
            'badge' => 'bg-rose-50 text-rose-700 ring-rose-200',
            'heading' => 'Create an administrator account.',
            'subtext' => 'This account will have elevated access for managing the system.',
            'button' => 'bg-rose-600 shadow-rose-200 hover:bg-rose-700 focus:ring-rose-200',
        ],
        'staff' => [
            'badge' => 'bg-sky-50 text-sky-700 ring-sky-200',
            'heading' => 'Create a staff account.',
            'subtext' => 'This account will be used for class, exam, and score management.',
            'button' => 'bg-sky-600 shadow-sky-200 hover:bg-sky-700 focus:ring-sky-200',
        ],
        default => [
            'badge' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
            'heading' => 'Create your student account.',
            'subtext' => 'Set up your account and start browsing courses and enrollment options.',
            'button' => 'bg-indigo-600 shadow-indigo-200 hover:bg-indigo-700 focus:ring-indigo-200',
        ],
    };
@endphp

@section('content')
    <section class="mx-auto grid min-h-[58vh] max-w-5xl items-center gap-10 lg:grid-cols-[1fr_0.9fr]">
        <div>
            <div class="mt-6">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-indigo-600">
                    Start organized
                </p>

                <h1 class="mt-3 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                    Manage your academic journey with ease.
                </h1>

                <p class="mt-5 max-w-xl text-base leading-7 text-slate-600">
                    Create a secure {{ strtolower($roleLabel) }} account and get access to the features available for your role.
                </p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 sm:p-8">
            <div class="mb-8">
                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $accentTone['badge'] }}">
                    {{ $roleLabel }} Account
                </span>

                <h2 class="mt-4 text-2xl font-bold text-slate-950">
                    {{ $accentTone['heading'] }}
                </h2>

                <p class="mt-2 text-sm text-slate-500">
                    {{ $accentTone['subtext'] }}
                </p>
            </div>

            <form method="POST" action="{{ $submitRoute }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        autocomplete="name"
                        required
                        autofocus
                        class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 @error('name') border-rose-300 focus:border-rose-500 focus:ring-rose-100 @enderror"
                        placeholder="Your full name"
                    >
                    @error('name')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 @error('email') border-rose-300 focus:border-rose-500 focus:ring-rose-100 @enderror"
                        placeholder="you@example.com"
                    >
                    @error('email')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 @error('password') border-rose-300 focus:border-rose-500 focus:ring-rose-100 @enderror"
                        placeholder="At least 8 characters"
                    >
                    @error('password')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">
                        Confirm password
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100"
                        placeholder="Repeat your password"
                    >
                </div>

                <div>
                    <label for="profile_image" class="block text-sm font-semibold text-slate-700">
                        Profile image
                    </label>
                    <input
                        id="profile_image"
                        name="profile_image"
                        type="file"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="mt-2 block w-full cursor-pointer rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/60 px-4 py-3 text-sm text-slate-600 shadow-sm outline-none transition file:mr-6 file:cursor-pointer file:rounded-xl file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:border-indigo-300 hover:bg-indigo-50 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 @error('profile_image') border-rose-300 focus:border-rose-500 focus:ring-rose-100 @enderror"
                    >
                    <p class="mt-2 text-xs font-medium text-slate-500">
                        Optional. JPG, PNG, or WEBP up to 2MB.
                    </p>
                    @error('profile_image')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="role" value="{{ $role }}">

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl px-5 py-3 text-sm font-bold text-white shadow-lg transition hover:-translate-y-0.5 focus:outline-none focus:ring-4 {{ $accentTone['button'] }}"
                >
                    Create {{ strtolower($roleLabel) }} account
                </button>
            </form>

            <p class="mt-7 text-center text-sm text-slate-600">
                Already have an account?
                <a href="{{ $loginRoute }}" class="font-bold text-indigo-600 transition hover:text-indigo-700">
                    Sign in
                </a>
            </p>
        </div>
    </section>
@endsection