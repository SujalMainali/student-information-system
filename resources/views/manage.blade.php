@extends('layouts.app')

@section('title', 'Manage · Dashboard')

@section('content')
    <section class="relative overflow-hidden rounded-[2rem] bg-slate-950 px-6 py-12 text-white shadow-2xl shadow-slate-200 sm:px-10 lg:px-14">
        <div class="absolute -right-24 -top-24 size-72 rounded-full bg-indigo-500/20 blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/3 size-72 rounded-full bg-amber-400/10 blur-3xl"></div>

        <div class="relative max-w-2xl">
            <span class="inline-flex rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-200">Workspace</span>
            <h1 class="mt-6 text-4xl font-bold tracking-tight sm:text-5xl">Everything you manage, in one place.</h1>
            <p class="mt-5 max-w-xl text-base leading-7 text-slate-300">Choose an area below to browse records, add something new, or make a quick update.</p>
        </div>
    </section>

    <section class="mt-10 grid gap-6 md:grid-cols-2">
        <x-manage.course-card />
        <x-manage.student-card />
    </section>
@endsection
