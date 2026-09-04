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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-black text-white" x-data="{ mobileNav: false }">

    <header class="sticky top-0 z-40 bg-black/90 backdrop-blur border-b border-white/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg text-white">
                    <span class="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-600 to-fuchsia-400 flex items-center justify-center text-sm">
                        {{ strtoupper(substr($settings->headline, 0, 1)) }}
                    </span>
                    {{ $settings->headline }}
                </a>

                <nav class="hidden sm:flex items-center gap-8 text-sm font-medium text-gray-400">
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
                            class="transition {{ request()->routeIs($item['pattern']) ? 'text-white' : 'hover:text-white' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <a href="{{ route('contact') }}" class="hidden sm:inline-flex items-center px-5 py-2.5 rounded-full bg-white text-black text-sm font-semibold hover:bg-gray-200 transition">
                    Contact Me
                </a>

                <button @click="mobileNav = !mobileNav" class="sm:hidden p-2 text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path x-show="!mobileNav" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileNav" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div x-show="mobileNav" x-cloak @click.away="mobileNav = false" class="sm:hidden border-t border-white/10 py-4 space-y-1 text-sm font-medium">
                <a href="{{ route('home') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-white/10 text-white' : 'text-gray-400' }}">Home</a>
                <a href="{{ route('about') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('about') ? 'bg-white/10 text-white' : 'text-gray-400' }}">About me</a>
                <a href="{{ route('projects.index') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('projects.*') ? 'bg-white/10 text-white' : 'text-gray-400' }}">Projects</a>
                <a href="{{ route('blog.index') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('blog.*') ? 'bg-white/10 text-white' : 'text-gray-400' }}">Blog</a>
                <a href="{{ route('contact') }}" class="block px-2 py-2 rounded-lg {{ request()->routeIs('contact') ? 'bg-white/10 text-white' : 'text-gray-400' }}">Contact</a>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-white/10 mt-24">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="flex flex-col sm:flex-row justify-between gap-8">
                <div class="max-w-sm">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg text-white">
                        <span class="w-8 h-8 rounded-full bg-gradient-to-tr from-pink-600 to-fuchsia-400 flex items-center justify-center text-sm">
                            {{ strtoupper(substr($settings->headline, 0, 1)) }}
                        </span>
                        {{ $settings->headline }}
                    </a>
                    <p class="mt-3 text-sm text-gray-500">{{ $settings->tagline }}.</p>
                    <x-social-links class="mt-5 text-gray-500" />
                </div>

                <div class="flex gap-16">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Site</p>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="{{ route('about') }}" class="hover:text-white">About</a></li>
                            <li><a href="{{ route('projects.index') }}" class="hover:text-white">Projects</a></li>
                            <li><a href="{{ route('blog.index') }}" class="hover:text-white">Blog</a></li>
                            <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Account</p>
                        <ul class="space-y-2 text-sm text-gray-400">
                            @auth
                                <li><a href="{{ route('admin.dashboard') }}" class="hover:text-white">Admin</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="hover:text-white">Admin login</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-white/10 text-sm text-gray-500">
                &copy; {{ now()->year }} {{ $settings->headline }}. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
