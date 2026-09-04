<x-site-layout :title="'Blog — ' . \App\Models\SiteSetting::current()->headline">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-12">
            <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Writing</p>
            <h1 class="text-4xl font-extrabold text-white">Blog</h1>
            <p class="mt-3 text-gray-400">Notes on projects, Laravel, and things I'm learning.</p>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        @if ($posts->isEmpty())
            <p class="text-gray-500">No posts yet — check back soon.</p>
        @else
            <div class="space-y-6">
                @foreach ($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="group flex gap-5 items-center rounded-2xl border border-white/10 p-4 sm:p-5 hover:border-white/20 hover:-translate-y-0.5 transition duration-300 bg-neutral-900">
                        <div class="w-28 h-20 sm:w-40 sm:h-28 rounded-xl overflow-hidden shrink-0">
                            @if ($post->cover_image)
                                <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <x-media-placeholder :title="$post->title" class="w-full h-full group-hover:scale-105 transition duration-500" />
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 mb-1">{{ $post->published_at->format('F j, Y') }}</p>
                            <h2 class="text-lg font-semibold text-white group-hover:text-fuchsia-400 transition truncate">{{ $post->title }}</h2>
                            @if ($post->excerpt)
                                <p class="mt-1 text-sm text-gray-400 line-clamp-2">{{ $post->excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </section>

</x-site-layout>
