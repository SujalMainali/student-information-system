@extends('layouts.app')

@section('title', 'Enrollment Error')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="rounded-3xl border border-rose-200 bg-white p-8 shadow-sm">
        <div class="flex items-start gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-rose-700">
                !
            </div>

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-rose-600">
                    Enrollment Error
                </p>

                <h1 class="mt-2 text-2xl font-bold text-slate-950">
                    Something went wrong
                </h1>

                <p class="mt-4 text-slate-600">
                    {{ $message }}
                </p>

                <div class="mt-6 text-sm text-slate-500">
                    Code: <span class="font-semibold">{{ $errorCode }}</span>
                    <br>
                    Status: <span class="font-semibold">{{ $status }}</span>
                </div>

                <div class="mt-8 flex gap-3">
                    <a href="{{ url()->previous() }}"
                       class="rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                        Go back
                    </a>

                    <a href="{{ route('dashboard') }}"
                       class="rounded-2xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection