@php
    $settings = \App\Models\SiteSetting::current();
    $avatar = $settings->avatarUrl();
    $initial = strtoupper(substr($settings->headline ?: 'P', 0, 1));
@endphp

<div {{ $attributes->merge(['class' => 'relative aspect-square w-full max-w-md mx-auto']) }}>
    <div class="absolute -inset-6 rounded-[2rem] bg-gradient-to-tr from-pink-600 via-fuchsia-500 to-orange-400 opacity-60 blur-2xl"></div>

    <div class="relative w-full h-full rounded-[1.75rem] overflow-hidden border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900">
        @if ($avatar)
            <img src="{{ $avatar }}" alt="{{ $settings->headline }}" class="absolute inset-0 w-full h-full object-cover" style="object-position: {{ $settings->avatarObjectPosition() }}">
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-950"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-slate-200 dark:text-white/10 font-extrabold leading-none select-none" style="font-size: min(28vw, 14rem);">{{ $initial }}</span>
            </div>
        @endif
    </div>
</div>
