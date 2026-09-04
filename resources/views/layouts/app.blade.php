<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-[13px] leading-[1.4em]" x-data="{ sidebarOpen: false }">
        <!-- WP-style top admin bar -->
        <header class="h-8 shrink-0 bg-[#1d2327] text-[#f0f0f1] flex items-center justify-between px-2 sm:px-4 relative z-50">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-1 -ml-1 text-[#f0f0f1]/70 hover:text-white">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-[13px] hover:text-[#72aee6] transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/><path d="M3 12h18"/></svg>
                    <span class="hidden sm:inline">{{ config('app.name', 'Admin') }}</span>
                </a>
            </div>

            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = ! open" class="flex items-center gap-2 text-[13px] text-[#f0f0f1]/90 hover:text-[#72aee6] transition py-1">
                    <span class="hidden sm:inline">Howdy, {{ Auth::user()->name }}</span>
                    <span class="w-6 h-6 rounded-full bg-[#2271b1] flex items-center justify-center text-[11px] font-semibold text-white shrink-0">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </button>

                <div x-show="open" x-cloak @click="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="absolute right-0 top-full w-44 bg-[#2c3338] shadow-lg py-1 text-[13px]">
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-[#f0f0f1]/90 hover:bg-[#2271b1] hover:text-white transition">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block px-3 py-2 text-[#f0f0f1]/90 hover:bg-[#2271b1] hover:text-white transition cursor-pointer">Log Out</a>
                    </form>
                </div>
            </div>
        </header>

        <div class="flex" style="height: calc(100vh - 2rem);">
            @include('layouts.navigation')

            <div class="flex-1 min-w-0 overflow-y-auto bg-[#f0f0f1]">
                @isset($header)
                    <div class="px-4 sm:px-6 lg:px-8 pt-6 pb-2 flex items-center flex-wrap gap-3">
                        {{ $header }}
                    </div>
                @endisset

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
