@props(['size' => 'lg'])

@php
    $sizes = [
        'md' => 'w-32 h-32 text-2xl sm:w-44 sm:h-44 sm:text-4xl',
        'lg' => 'w-40 h-40 text-4xl sm:w-56 sm:h-56 sm:text-6xl',
    ];
    $sizeClasses = $sizes[$size] ?? $sizes['lg'];
    $settings = \App\Models\SiteSetting::current();
    $initial = strtoupper(substr($settings->headline ?: 'P', 0, 1));
    $avatar = $settings->avatarUrl();
@endphp

<div {{ $attributes->merge(['class' => "relative $sizeClasses shrink-0"]) }}>
    <div class="absolute -inset-2 rounded-full bg-gradient-to-tr from-pink-600 via-fuchsia-500 to-orange-400 opacity-50 blur-xl"></div>
    <div class="relative w-full h-full rounded-full p-1 bg-gradient-to-tr from-pink-600 to-fuchsia-400">
        <div class="w-full h-full rounded-full overflow-hidden bg-white dark:bg-slate-900 ring-4 ring-white dark:ring-slate-950">
            @if ($avatar)
                <img src="{{ $avatar }}" alt="{{ $settings->headline }}" class="w-full h-full object-cover" style="object-position: {{ $settings->avatarObjectPosition() }}">
            @else
                <div class="w-full h-full flex items-center justify-center bg-slate-100 dark:bg-slate-800 font-bold text-fuchsia-600 dark:text-fuchsia-400">
                    {{ $initial }}
                </div>
            @endif
        </div>
    </div>
</div>
