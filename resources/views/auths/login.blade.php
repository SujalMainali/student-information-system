@extends('layouts.app')

@section('title', 'Login | Manage')

@section('content')
    <section class="mx-auto grid min-h-[58vh] max-w-5xl items-center gap-10 lg:grid-cols-[1fr_0.9fr]">
        <div>
            <div class="mt-6">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-indigo-600">Welcome back</p>
                <h1 class="mt-3 text-4xl font-bold tracking-tight text-slate-950 sm:text-5xl">
                    Sign in to your workspace.
                </h1>
                <p class="mt-5 max-w-xl text-base leading-7 text-slate-600">
                    Continue managing courses, students, enrollments, and course documents from one tidy place.
                </p>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70 sm:p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-slate-950">Login</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Enter your account details below.
                </p>
            </div>

            <form method="POST" action="{{ route('auth.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        autofocus
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
                        autocomplete="current-password"
                        required
                        class="mt-2 block w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 @error('password') border-rose-300 focus:border-rose-500 focus:ring-rose-100 @enderror"
                        placeholder="Your password"
                    >
                    @error('password')
                        <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200"
                >
                    Sign in
                </button>
            </form>

            <p class="mt-7 text-center text-sm text-slate-600">
                New to Manage?
                <a href="{{ route('auth.register') }}" class="font-bold text-indigo-600 transition hover:text-indigo-700">
                    Create an account
                </a>
            </p>
        </div>
    </section>
@endsection
