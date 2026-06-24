<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Manage courses and students from one simple workspace.">

        <title>@yield('title', 'Manage')</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        <div class="flex min-h-screen flex-col">
            @include('partials.header')

            <main class="flex-1">
                <div class="mx-auto min-h-[62vh] w-full max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
                    @if (session('success'))
                        <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @yield('content', '<div class="min-h-[52vh]"></div>')
                </div>
            </main>

            @include('partials.footer')
        </div>

        @stack('scripts')
    </body>
</html>
