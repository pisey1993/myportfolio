<x-site-layout :title="'Contact — ' . $settings->headline">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-24 grid sm:grid-cols-5 gap-12">
            <div class="sm:col-span-2">
                <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Contact</p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Get in touch</h1>
                <p class="mt-4 text-slate-600 dark:text-slate-400">
                    Have a project in mind or just want to say hi? Send a message and I'll get back to you soon.
                </p>

                @php
                    $connectLinks = array_filter([
                        $settings->email ? [
                            'href' => 'mailto:'.$settings->email,
                            'label' => 'Email',
                            'sub' => $settings->email,
                            'external' => false,
                        ] : null,
                        $settings->linkedin_url ? [
                            'href' => $settings->linkedin_url,
                            'label' => 'LinkedIn',
                            'sub' => 'Connect with me',
                            'external' => true,
                        ] : null,
                        $settings->telegram_url ? [
                            'href' => $settings->telegram_url,
                            'label' => 'Telegram',
                            'sub' => '@'.trim(parse_url($settings->telegram_url, PHP_URL_PATH), '/'),
                            'external' => true,
                        ] : null,
                        $settings->github_url ? [
                            'href' => $settings->github_url,
                            'label' => 'GitHub',
                            'sub' => 'See my code',
                            'external' => true,
                        ] : null,
                        $settings->twitter_url ? [
                            'href' => $settings->twitter_url,
                            'label' => 'Twitter / X',
                            'sub' => 'Follow me',
                            'external' => true,
                        ] : null,
                    ]);
                @endphp

                @if (count($connectLinks))
                    <div class="mt-8 space-y-3">
                        @foreach ($connectLinks as $link)
                            <a href="{{ $link['href'] }}" @if($link['external']) target="_blank" rel="noopener" @endif
                                class="group flex items-center gap-3 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 p-3 hover:border-fuchsia-300 dark:hover:border-fuchsia-500/40 hover:shadow-sm transition">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg overflow-hidden bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-slate-300">
                                    @switch($link['label'])
                                        @case('Email')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75A2.25 2.25 0 0 1 5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v10.5A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25V6.75Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m3.5 6 8.5 6 8.5-6"/></svg>
                                            @break
                                        @case('LinkedIn')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.03-1.85-3.03-1.86 0-2.14 1.45-2.14 2.94v5.66H9.34V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45ZM22.22 0H1.77C.8 0 0 .78 0 1.75v20.5C0 23.22.8 24 1.77 24h20.45c.98 0 1.78-.78 1.78-1.75V1.75C24 .78 23.2 0 22.22 0Z"/></svg>
                                            @break
                                        @case('Telegram')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.5 1.201-.82 1.23-.697.064-1.226-.461-1.902-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.911.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.139-5.062 3.345-.479.329-.913.489-1.302.481-.428-.009-1.252-.242-1.865-.442-.751-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.831-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.477-1.635.099-.002.321.023.465.14.119.098.152.23.168.323.016.093.036.306.02.472z"/></svg>
                                            @break
                                        @case('GitHub')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .5C5.65.5.5 5.65.5 12c0 5.09 3.29 9.4 7.86 10.93.57.1.79-.25.79-.55 0-.27-.01-1.16-.02-2.1-3.2.7-3.88-1.36-3.88-1.36-.52-1.34-1.28-1.69-1.28-1.69-1.04-.72.08-.7.08-.7 1.15.08 1.76 1.19 1.76 1.19 1.03 1.76 2.7 1.25 3.36.96.1-.75.4-1.25.73-1.54-2.55-.29-5.24-1.28-5.24-5.7 0-1.26.45-2.29 1.19-3.09-.12-.29-.52-1.47.11-3.06 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.64 1.59.24 2.77.12 3.06.74.8 1.19 1.83 1.19 3.09 0 4.43-2.7 5.4-5.27 5.69.42.36.78 1.07.78 2.16 0 1.56-.01 2.82-.01 3.2 0 .31.21.66.8.55A10.52 10.52 0 0 0 23.5 12c0-6.35-5.15-11.5-11.5-11.5Z"/></svg>
                                            @break
                                        @case('Twitter / X')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.9 2H22l-7.6 8.7L23.3 22h-7.2l-5.6-7.3L4 22H1l8.1-9.3L1 2h7.4l5.1 6.7L18.9 2Zm-1.3 18h1.9L7 4h-2l12.6 16Z"/></svg>
                                            @break
                                    @endswitch
                                </span>
                                <span class="min-w-0">
                                    <span class="block text-sm font-semibold text-slate-900 dark:text-white">{{ $link['label'] }}</span>
                                    <span class="block text-xs text-slate-500 dark:text-slate-400 truncate">{{ $link['sub'] }}</span>
                                </span>
                                <svg class="ml-auto w-4 h-4 shrink-0 text-slate-300 dark:text-slate-600 group-hover:text-fuchsia-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0-4 4m4-4H3"/></svg>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="sm:col-span-3">
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm p-6 sm:p-8">
                    @if (session('status'))
                        <div class="mb-6 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                        @csrf

                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-lg bg-slate-100 dark:bg-white/5 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">
                                @error('name')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="mt-1 block w-full rounded-lg bg-slate-100 dark:bg-white/5 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">
                                @error('email')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                class="mt-1 block w-full rounded-lg bg-slate-100 dark:bg-white/5 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">
                            @error('subject')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Message</label>
                            <textarea name="message" id="message" rows="5" required
                                class="mt-1 block w-full rounded-lg bg-slate-100 dark:bg-white/5 border-slate-200 dark:border-white/10 text-slate-900 dark:text-white placeholder-slate-400 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="inline-flex items-center px-6 py-2.5 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:from-pink-500 hover:to-fuchsia-400 transition">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-site-layout>
