<x-site-layout :title="'Video Blog — ' . \App\Models\SiteSetting::current()->headline">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>
        <div class="anim-stagger max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-12">
            <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Watching</p>
            <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white">Video Blog</h1>
            <p class="mt-3 text-slate-600 dark:text-slate-400">Video walkthroughs, demos, and talks.</p>
        </div>
    </section>

    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        @if ($posts->isEmpty())
            <p class="text-slate-500">No videos yet — check back soon.</p>
        @else
            <div class="anim-stagger space-y-6">
                @foreach ($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="group flex gap-5 items-center rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm p-4 sm:p-5 hover:border-slate-300 dark:hover:border-white/20 hover:shadow-md hover:-translate-y-0.5 transition duration-300 bg-white dark:bg-slate-900">
                        <div class="relative w-28 h-20 sm:w-40 sm:h-28 rounded-xl overflow-hidden shrink-0">
                            @if ($post->cover_image)
                                <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <x-media-placeholder :title="$post->title" class="w-full h-full group-hover:scale-105 transition duration-500" />
                            @endif
                            <span class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition">
                                <span class="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center shadow">
                                    <svg class="w-4 h-4 text-slate-900 translate-x-[1px]" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                </span>
                            </span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-500 mb-1">{{ $post->published_at->format('F j, Y') }}</p>
                            <h2 class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-400 transition truncate">{{ $post->title }}</h2>
                            @if ($post->excerpt)
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{{ $post->excerpt }}</p>
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
