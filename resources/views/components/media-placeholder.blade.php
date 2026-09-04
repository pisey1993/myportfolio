@props(['title' => '', 'class' => ''])

@php
    $palettes = [
        'from-pink-600 to-fuchsia-600',
        'from-fuchsia-600 to-purple-600',
        'from-orange-500 to-pink-600',
        'from-purple-600 to-pink-500',
        'from-rose-600 to-fuchsia-600',
    ];
    $index = $title ? crc32($title) % count($palettes) : 0;
    $gradient = $palettes[$index];
    $initial = strtoupper(substr($title ?: '?', 0, 1));
    $patternId = 'dots-'.\Illuminate\Support\Str::random(8);
@endphp

<div {{ $attributes->merge(['class' => "relative flex items-center justify-center overflow-hidden bg-gradient-to-br $gradient $class"]) }}>
    <svg class="absolute inset-0 w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <pattern id="{{ $patternId }}" x="0" y="0" width="18" height="18" patternUnits="userSpaceOnUse">
                <circle cx="2" cy="2" r="1.6" fill="white" />
            </pattern>
        </defs>
        <rect width="100%" height="100%" fill="url(#{{ $patternId }})" />
    </svg>
    <span class="relative text-white/90 font-bold text-5xl tracking-tight select-none">{{ $initial }}</span>
</div>
