<x-site-layout :title="'Contact — ' . $settings->headline">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-24 grid sm:grid-cols-5 gap-12">
            <div class="sm:col-span-2">
                <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Contact</p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white">Get in touch</h1>
                <p class="mt-4 text-gray-400">
                    Have a project in mind or just want to say hi? Send a message and I'll get back to you soon.
                </p>

                @if ($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-white hover:text-fuchsia-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6.75A2.25 2.25 0 0 1 5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v10.5A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25V6.75Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m3.5 6 8.5 6 8.5-6"/></svg>
                        {{ $settings->email }}
                    </a>
                @endif

                <x-social-links class="mt-6 text-gray-500" />
            </div>

            <div class="sm:col-span-3">
                <div class="bg-neutral-900 rounded-2xl border border-white/10 p-6 sm:p-8">
                    @if (session('status'))
                        <div class="mb-6 rounded-lg bg-green-500/10 border border-green-500/20 px-4 py-3 text-sm text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                        @csrf

                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="mt-1 block w-full rounded-lg bg-white/5 border-white/10 text-white placeholder-gray-500 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">
                                @error('name')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    class="mt-1 block w-full rounded-lg bg-white/5 border-white/10 text-white placeholder-gray-500 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">
                                @error('email')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-300">Subject</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                class="mt-1 block w-full rounded-lg bg-white/5 border-white/10 text-white placeholder-gray-500 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">
                            @error('subject')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300">Message</label>
                            <textarea name="message" id="message" rows="5" required
                                class="mt-1 block w-full rounded-lg bg-white/5 border-white/10 text-white placeholder-gray-500 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 sm:text-sm">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
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
