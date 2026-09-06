@props(['url', 'title'])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <span class="text-xs font-medium text-slate-500 dark:text-slate-500 mr-1">Share</span>

    <a href="https://twitter.com/intent/tweet?text={{ urlencode($title) }}&url={{ urlencode($url) }}" target="_blank" rel="noopener"
        aria-label="Share on X"
        class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-white/10 transition">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.9 2H22l-7.6 8.7L23.3 22h-7.2l-5.6-7.3L4 22H1l8.1-9.3L1 2h7.4l5.1 6.7L18.9 2Zm-1.3 18h1.9L7 4h-2l12.6 16Z"/></svg>
    </a>

    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}" target="_blank" rel="noopener"
        aria-label="Share on Facebook"
        class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-white/10 transition">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94Z"/></svg>
    </a>

    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($url) }}" target="_blank" rel="noopener"
        aria-label="Share on LinkedIn"
        class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-white/10 transition">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.03-1.85-3.03-1.86 0-2.14 1.45-2.14 2.94v5.66H9.34V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45ZM22.22 0H1.77C.8 0 0 .78 0 1.75v20.5C0 23.22.8 24 1.77 24h20.45c.98 0 1.78-.78 1.78-1.75V1.75C24 .78 23.2 0 22.22 0Z"/></svg>
    </a>

    <button type="button" x-data="{ copied: false }"
        @click="
            (navigator.clipboard && window.isSecureContext
                ? navigator.clipboard.writeText(@js($url))
                : (() => {
                    const el = document.createElement('textarea');
                    el.value = @js($url);
                    el.style.position = 'fixed';
                    el.style.opacity = '0';
                    document.body.appendChild(el);
                    el.select();
                    document.execCommand('copy');
                    document.body.removeChild(el);
                    return Promise.resolve();
                })()
            ).then(() => {
                copied = true;
                window.Toast && window.Toast('Link copied to clipboard', 'success');
                setTimeout(() => copied = false, 2000);
            }).catch(() => {
                window.Toast && window.Toast('Could not copy link', 'error');
            });
        "
        aria-label="Copy link"
        class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-slate-900 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-white dark:hover:bg-white/10 transition">
        <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5 21 3m0 0h-5.25M21 3v5.25M11 4H6.75A2.75 2.75 0 0 0 4 6.75v10.5A2.75 2.75 0 0 0 6.75 20h10.5A2.75 2.75 0 0 0 20 17.25V13"/></svg>
        <svg x-show="copied" x-cloak class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
    </button>
</div>
