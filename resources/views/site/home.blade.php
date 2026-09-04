<x-site-layout :title="config('app.name') . ' — Portfolio'">

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
        <p class="text-sm font-medium text-indigo-600 mb-3">Hello, I'm</p>
        <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-gray-900">
            {{ config('app.name', 'Pisey') }}
        </h1>
        <p class="mt-5 text-lg text-gray-600 max-w-2xl">
            A software developer building web applications with Laravel. I enjoy turning
            ideas into clean, working products — from internal business tools to personal projects.
        </p>
        <div class="mt-8 flex flex-wrap gap-4">
            <a href="{{ route('projects.index') }}" class="inline-flex items-center px-5 py-2.5 rounded-md bg-gray-900 text-white text-sm font-medium hover:bg-gray-700 transition">
                View my work
            </a>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-5 py-2.5 rounded-md border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                Get in touch
            </a>
        </div>
    </section>

    @if ($featuredProjects->isNotEmpty())
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
        <div class="flex items-end justify-between mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">Featured Projects</h2>
            <a href="{{ route('projects.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">View all &rarr;</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($featuredProjects as $project)
                <a href="{{ route('projects.show', $project) }}" class="group block rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="aspect-video bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if ($project->image)
                            <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-300 text-3xl font-semibold">{{ substr($project->title, 0, 1) }}</span>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition">{{ $project->title }}</h3>
                        <p class="mt-1.5 text-sm text-gray-600 line-clamp-2">{{ $project->summary }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    @if ($skills->isNotEmpty())
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
        <h2 class="text-2xl font-semibold text-gray-900 mb-8">Skills</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($skills as $category => $items)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">{{ $category }}</h3>
                    <ul class="space-y-1.5">
                        @foreach ($items as $skill)
                            <li class="text-sm text-gray-700">{{ $skill->name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    @if ($latestPosts->isNotEmpty())
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
        <div class="flex items-end justify-between mb-8">
            <h2 class="text-2xl font-semibold text-gray-900">From the Blog</h2>
            <a href="{{ route('blog.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">View all &rarr;</a>
        </div>
        <div class="grid sm:grid-cols-3 gap-6">
            @foreach ($latestPosts as $post)
                <a href="{{ route('blog.show', $post) }}" class="block group">
                    <p class="text-xs text-gray-400 mb-1">{{ $post->published_at->format('M j, Y') }}</p>
                    <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition">{{ $post->title }}</h3>
                    @if ($post->excerpt)
                        <p class="mt-1.5 text-sm text-gray-600 line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                </a>
            @endforeach
        </div>
    </section>
    @endif

</x-site-layout>
