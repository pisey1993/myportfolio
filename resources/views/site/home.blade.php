<x-site-layout :title="$settings->headline . ' — Portfolio'">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-1/3 left-1/2 -translate-x-1/2 w-[60rem] h-[30rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-20 grid sm:grid-cols-2 gap-14 items-center">
            <div>
                <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-[1.1]">
                    <span class="bg-gradient-to-r from-pink-500 via-fuchsia-400 to-orange-300 bg-clip-text text-transparent">{{ $settings->tagline }}</span><br>
                    <span class="text-white">Hi, I'm {{ $settings->headline }}</span>
                </h1>
                <p class="mt-6 text-gray-400 max-w-md">
                    {{ $settings->hero_description }}
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('contact') }}" class="group inline-flex items-center gap-3 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:from-pink-500 hover:to-fuchsia-400 transition">
                        Get In Touch
                        <span class="w-8 h-8 rounded-full bg-white text-black flex items-center justify-center group-hover:translate-x-0.5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </a>
                    <a href="{{ route('projects.index') }}" class="inline-flex items-center px-6 py-3 rounded-full border border-white/20 text-white text-sm font-semibold hover:bg-white/5 transition">
                        View Work
                    </a>
                </div>
                <x-social-links class="mt-10 text-gray-500" />
            </div>

            <x-hero-photo />
        </div>
    </section>

    @if ($skills->isNotEmpty())
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-white">
                What <span class="bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent">I do</span>
            </h2>
            <p class="mt-3 text-gray-400">A quick look at where I focus, drawn from ten years leading IT for a growing insurance business.</p>
        </div>

        @php
            $services = [
                [
                    'title' => 'IT Leadership & Strategy',
                    'description' => 'Strategic planning, vendor management, and building & mentoring development teams from the ground up.',
                    'accent' => 'from-pink-500 to-rose-500',
                    'icon' => '<circle cx="12" cy="12" r="9"/><polygon points="16 8 13.5 13.5 8 16 10.5 10.5 16 8"/>',
                ],
                [
                    'title' => 'AI-Powered Development',
                    'description' => 'Google Gemini API integrations, AI assistants, and automated reporting pipelines grounded in real business data.',
                    'accent' => 'from-fuchsia-500 to-purple-500',
                    'icon' => '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3z"/><path d="M19 14l.9 2.1L22 17l-2.1.9L19 20l-.9-2.1L16 17l2.1-.9L19 14z"/>',
                ],
                [
                    'title' => 'System Modernization',
                    'description' => 'Migrating legacy platforms to modern, web-based systems — like our FileMaker-to-Laravel Core System rebuild.',
                    'accent' => 'from-orange-400 to-pink-500',
                    'icon' => '<polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/>',
                ],
            ];
        @endphp

        <div class="grid sm:grid-cols-3 gap-6">
            @foreach ($services as $service)
                <div class="rounded-2xl bg-neutral-900 border border-white/10 overflow-hidden">
                    <div class="h-1 bg-gradient-to-r {{ $service['accent'] }}"></div>
                    <div class="p-6">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $service['accent'] }} flex items-center justify-center mb-5">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $service['icon'] !!}</svg>
                        </div>
                        <h3 class="font-semibold text-white">{{ $service['title'] }}</h3>
                        <p class="mt-2 text-sm text-gray-400">{{ $service['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if ($featuredProjects->isNotEmpty())
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-white/10">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-sm font-semibold bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent uppercase tracking-widest mb-1">Selected work</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Featured Projects</h2>
            </div>
            <a href="{{ route('projects.index') }}" class="text-sm font-medium text-fuchsia-400 hover:text-fuchsia-300 shrink-0">View all &rarr;</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($featuredProjects as $project)
                <a href="{{ route('projects.show', $project) }}" class="group block rounded-2xl border border-white/10 overflow-hidden hover:border-white/20 hover:-translate-y-1 transition duration-300 bg-neutral-900">
                    <div class="aspect-video overflow-hidden">
                        @if ($project->image)
                            <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <x-media-placeholder :title="$project->title" class="w-full h-full group-hover:scale-105 transition duration-500" />
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-white group-hover:text-fuchsia-400 transition">{{ $project->title }}</h3>
                        <p class="mt-1.5 text-sm text-gray-400 line-clamp-2">{{ $project->summary }}</p>
                        @if ($project->tech_stack)
                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach (array_slice($project->techStackList(), 0, 3) as $tech)
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-white/5 text-gray-400 border border-white/10">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    @if ($skills->isNotEmpty())
    <section class="border-y border-white/10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <p class="text-sm font-semibold bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent uppercase tracking-widest mb-1">What I work with</p>
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-10">Skills</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($skills as $category => $items)
                    <div class="rounded-2xl bg-neutral-900 border border-white/10 p-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">{{ $category }}</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($items as $skill)
                                <span class="text-sm px-3 py-1 rounded-full bg-white/5 text-gray-300 border border-white/10">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($latestPosts->isNotEmpty())
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-sm font-semibold bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent uppercase tracking-widest mb-1">Writing</p>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">From the Blog</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="text-sm font-medium text-fuchsia-400 hover:text-fuchsia-300 shrink-0">View all &rarr;</a>
        </div>
        <div class="grid sm:grid-cols-3 gap-6">
            @foreach ($latestPosts as $post)
                <a href="{{ route('blog.show', $post) }}" class="group block rounded-2xl border border-white/10 overflow-hidden hover:border-white/20 hover:-translate-y-1 transition duration-300 bg-neutral-900">
                    <div class="aspect-[16/10] overflow-hidden">
                        @if ($post->cover_image)
                            <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <x-media-placeholder :title="$post->title" class="w-full h-full group-hover:scale-105 transition duration-500" />
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-gray-500 mb-1.5">{{ $post->published_at->format('M j, Y') }}</p>
                        <h3 class="font-semibold text-white group-hover:text-fuchsia-400 transition">{{ $post->title }}</h3>
                        @if ($post->excerpt)
                            <p class="mt-1.5 text-sm text-gray-400 line-clamp-2">{{ $post->excerpt }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="relative overflow-hidden rounded-3xl bg-neutral-900 border border-white/10 px-8 py-14 sm:px-16 text-center">
            <div class="absolute inset-0 bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10"></div>
            <div class="relative">
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Have a project in mind?</h2>
                <p class="mt-3 text-gray-400 max-w-xl mx-auto">I'm always open to discussing new projects and opportunities.</p>
                <a href="{{ route('contact') }}" class="mt-7 inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:from-pink-500 hover:to-fuchsia-400 transition">
                    Get in touch
                </a>
            </div>
        </div>
    </section>

</x-site-layout>
