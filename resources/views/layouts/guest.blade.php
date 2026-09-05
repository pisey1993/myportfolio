<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Log In' }} &middot; {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-sm text-slate-900 bg-slate-50">
        <div class="min-h-screen w-full flex flex-col items-center justify-center px-4 py-10 relative overflow-hidden">
            <!-- soft background glow -->
            <div class="pointer-events-none absolute inset-0 -z-10">
                <div class="absolute -top-40 -left-32 w-[28rem] h-[28rem] rounded-full bg-indigo-200/50 blur-3xl"></div>
                <div class="absolute -bottom-40 -right-32 w-[28rem] h-[28rem] rounded-full bg-violet-200/50 blur-3xl"></div>
            </div>

            <div class="w-full max-w-[380px]">

                <div class="mb-8 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group">
                        <span class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/25 group-hover:shadow-indigo-600/40 transition-shadow">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/><path d="M3 12h18"/></svg>
                        </span>
                        <span class="text-[20px] font-semibold tracking-tight text-slate-900">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <div class="bg-white border border-slate-200 shadow-xl shadow-slate-900/5 rounded-2xl px-7 py-8 sm:px-9">
                    {{ $slot }}
                </div>

                <p class="mt-6 text-center text-sm">
                    <a href="{{ route('home') }}" class="text-slate-400 hover:text-indigo-600 transition">&larr; Back to {{ config('app.name', 'site') }}</a>
                </p>
            </div>
        </div>
    </body>
</html>
