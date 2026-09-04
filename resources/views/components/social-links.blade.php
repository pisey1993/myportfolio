@props(['class' => 'text-gray-400'])

@php
    $settings = \App\Models\SiteSetting::current();
    $links = array_filter([
        'github' => $settings->github_url,
        'linkedin' => $settings->linkedin_url,
        'twitter' => $settings->twitter_url,
        'email' => $settings->email ? 'mailto:'.$settings->email : null,
    ]);
@endphp

@if (count($links))
    <div {{ $attributes->merge(['class' => "flex items-center gap-4 $class"]) }}>
        @if (isset($links['github']))
            <a href="{{ $links['github'] }}" target="_blank" rel="noopener" aria-label="GitHub" class="hover:text-white transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .5C5.65.5.5 5.65.5 12c0 5.09 3.29 9.4 7.86 10.93.57.1.79-.25.79-.55 0-.27-.01-1.16-.02-2.1-3.2.7-3.88-1.36-3.88-1.36-.52-1.34-1.28-1.69-1.28-1.69-1.04-.72.08-.7.08-.7 1.15.08 1.76 1.19 1.76 1.19 1.03 1.76 2.7 1.25 3.36.96.1-.75.4-1.25.73-1.54-2.55-.29-5.24-1.28-5.24-5.7 0-1.26.45-2.29 1.19-3.09-.12-.29-.52-1.47.11-3.06 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.64 1.59.24 2.77.12 3.06.74.8 1.19 1.83 1.19 3.09 0 4.43-2.7 5.4-5.27 5.69.42.36.78 1.07.78 2.16 0 1.56-.01 2.82-.01 3.2 0 .31.21.66.8.55A10.52 10.52 0 0 0 23.5 12c0-6.35-5.15-11.5-11.5-11.5Z"/></svg>
            </a>
        @endif
        @if (isset($links['linkedin']))
            <a href="{{ $links['linkedin'] }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="hover:text-white transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.03-1.85-3.03-1.86 0-2.14 1.45-2.14 2.94v5.66H9.34V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45ZM22.22 0H1.77C.8 0 0 .78 0 1.75v20.5C0 23.22.8 24 1.77 24h20.45c.98 0 1.78-.78 1.78-1.75V1.75C24 .78 23.2 0 22.22 0Z"/></svg>
            </a>
        @endif
        @if (isset($links['twitter']))
            <a href="{{ $links['twitter'] }}" target="_blank" rel="noopener" aria-label="Twitter / X" class="hover:text-white transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.9 2H22l-7.6 8.7L23.3 22h-7.2l-5.6-7.3L4 22H1l8.1-9.3L1 2h7.4l5.1 6.7L18.9 2Zm-1.3 18h1.9L7 4h-2l12.6 16Z"/></svg>
            </a>
        @endif
        @if (isset($links['email']))
            <a href="{{ $links['email'] }}" aria-label="Email" class="hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75A2.25 2.25 0 0 1 5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v10.5A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25V6.75Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m3.5 6 8.5 6 8.5-6"/></svg>
            </a>
        @endif
    </div>
@endif
