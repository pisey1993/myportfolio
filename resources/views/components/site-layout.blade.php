@props(['title' => null, 'description' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Portfolio') }}</title>
    <meta name="description" content="{{ $description ?? 'Personal portfolio, projects, and blog.' }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    <header class="border-b border-gray-100 sticky top-0 bg-white/90 backdrop-blur z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="font-semibold text-lg tracking-tight">
                    {{ config('app.name', 'Portfolio') }}
                </a>

                <nav class="hidden sm:flex items-center gap-8 text-sm font-medium text-gray-600">
                    <a href="{{ route('home') }}" class="hover:text-gray-900 {{ request()->routeIs('home') ? 'text-gray-900' : '' }}">Home</a>
                    <a href="{{ route('about') }}" class="hover:text-gray-900 {{ request()->routeIs('about') ? 'text-gray-900' : '' }}">About</a>
                    <a href="{{ route('projects.index') }}" class="hover:text-gray-900 {{ request()->routeIs('projects.*') ? 'text-gray-900' : '' }}">Projects</a>
                    <a href="{{ route('blog.index') }}" class="hover:text-gray-900 {{ request()->routeIs('blog.*') ? 'text-gray-900' : '' }}">Blog</a>
                    <a href="{{ route('contact') }}" class="hover:text-gray-900 {{ request()->routeIs('contact') ? 'text-gray-900' : '' }}">Contact</a>
                </nav>

                <div class="sm:hidden" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 text-gray-500">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false" class="absolute left-0 right-0 top-16 bg-white border-b border-gray-100 px-4 py-4 space-y-3 text-sm font-medium">
                        <a href="{{ route('home') }}" class="block">Home</a>
                        <a href="{{ route('about') }}" class="block">About</a>
                        <a href="{{ route('projects.index') }}" class="block">Projects</a>
                        <a href="{{ route('blog.index') }}" class="block">Blog</a>
                        <a href="{{ route('contact') }}" class="block">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-gray-100 mt-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-gray-500">
            <p>&copy; {{ now()->year }} {{ config('app.name', 'Portfolio') }}. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="{{ route('contact') }}" class="hover:text-gray-800">Get in touch</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-800">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-gray-800">Admin login</a>
                @endauth
            </div>
        </div>
    </footer>
</body>
</html>
