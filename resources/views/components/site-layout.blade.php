@props(['title' => null, 'description' => null])
@php $settings = \App\Models\SiteSetting::current(); @endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? $settings->headline }}</title>
    <meta name="description" content="{{ $description ?? 'Personal portfolio, projects, and blog.' }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <script>
        (function () {
            if (localStorage.getItem('theme') !== 'light') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-slate-900 dark:bg-slate-950 dark:text-white" x-data="{ mobileNav: false }">

    <header class="anim-fade-down sticky top-0 z-40 bg-white/90 dark:bg-slate-950/90 backdrop-blur border-b border-slate-200 dark:border-white/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg text-slate-900 dark:text-white">
                    <span class="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-600 to-fuchsia-400 flex items-center justify-center text-sm">
                        {{ strtoupper(substr($settings->headline, 0, 1)) }}
                    </span>
                    {{ $settings->headline }}
                </a>

                <nav class="hidden sm:flex items-center gap-8 text-sm font-medium text-slate-600 dark:text-slate-400">
                    @php
                        $navItems = [
                            ['route' => 'home', 'pattern' => 'home', 'label' => 'Home'],
                            ['route' => 'about', 'pattern' => 'about', 'label' => 'About me'],
                            ['route' => 'projects.index', 'pattern' => 'projects.*', 'label' => 'Projects'],
                            ['route' => 'blog.index', 'pattern' => 'blog.*', 'label' => 'Blog'],
                        ];
                    @endphp
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="transition {{ request()->routeIs($item['pattern']) ? 'text-slate-900 dark:text-white' : 'hover:text-slate-900 dark:hover:text-white' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-2">
                    <button
                        @click="
                            document.documentElement.classList.toggle('dark');
                            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                        "
                        aria-label="Toggle theme"
                        class="p-2 rounded-full text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-white/10 transition">
                        <svg class="w-[18px] h-[18px] hidden dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                        <svg class="w-[18px] h-[18px] block dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
                    </button>

                    <a href="{{ route('contact') }}" class="hidden sm:inline-flex items-center px-5 py-2.5 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-950 text-sm font-semibold hover:bg-slate-700 dark:hover:bg-slate-200 transition">
                        Contact Me
                    </a>

                    <button @click="mobileNav = !mobileNav" class="sm:hidden p-2 text-slate-900 dark:text-white">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path x-show="!mobileNav" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileNav" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="mobileNav" x-cloak @click.away="mobileNav = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="sm:hidden border-t border-slate-200 dark:border-white/10 py-4 space-y-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-slate-100 dark:bg-white/10 text-slate-900 dark:text-white' : 'text-slate-600 dark:text-slate-400' }}">Home</a>
                <a href="{{ route('about') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('about') ? 'bg-slate-100 dark:bg-white/10 text-slate-900 dark:text-white' : 'text-slate-600 dark:text-slate-400' }}">About me</a>
                <a href="{{ route('projects.index') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('projects.*') ? 'bg-slate-100 dark:bg-white/10 text-slate-900 dark:text-white' : 'text-slate-600 dark:text-slate-400' }}">Projects</a>
                <a href="{{ route('blog.index') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('blog.*') ? 'bg-slate-100 dark:bg-white/10 text-slate-900 dark:text-white' : 'text-slate-600 dark:text-slate-400' }}">Blog</a>
                <a href="{{ route('contact') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('contact') ? 'bg-slate-100 dark:bg-white/10 text-slate-900 dark:text-white' : 'text-slate-600 dark:text-slate-400' }}">Contact</a>
            </div>
        </div>
    </header>

    <main class="animate__animated animate__fadeIn">
        {{ $slot }}
    </main>

    <div id="toast-region" aria-live="polite"></div>
    @if (session('status'))
        <script>document.addEventListener('DOMContentLoaded', function () { Toast(@json(session('status')), @json(session('status_type'))); });</script>
    @endif

    <footer class="border-t border-slate-200 dark:border-white/10 mt-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex flex-col sm:flex-row justify-between gap-8">
                <div class="max-w-sm">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg text-slate-900 dark:text-white">
                        <span class="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-600 to-fuchsia-400 flex items-center justify-center text-sm">
                            {{ strtoupper(substr($settings->headline, 0, 1)) }}
                        </span>
                        {{ $settings->headline }}
                    </a>
                    <p class="mt-3 text-sm text-slate-500 dark:text-slate-500">{{ $settings->tagline }}.</p>
                    <x-social-links class="mt-5 text-slate-500 dark:text-slate-500" />
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">Site</p>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('about') }}" class="hover:text-slate-900 dark:hover:text-white">About</a></li>
                        <li><a href="{{ route('projects.index') }}" class="hover:text-slate-900 dark:hover:text-white">Projects</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-slate-900 dark:hover:text-white">Blog</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-slate-900 dark:hover:text-white">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-slate-200 dark:border-white/10 text-sm text-slate-500">
                &copy; {{ now()->year }} {{ $settings->headline }}. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
