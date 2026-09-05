<x-site-layout :title="$post->title . ' — ' . \App\Models\SiteSetting::current()->headline" :description="$post->excerpt">

    <article>
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
            </div>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 pb-8">
                <a href="{{ route('blog.index') }}" class="text-sm text-slate-500 hover:text-slate-900 dark:hover:text-white">&larr; All posts</a>

                <p class="mt-4 text-xs text-slate-500">{{ $post->published_at->format('F j, Y') }}</p>
                <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">{{ $post->title }}</h1>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="aspect-[16/9] rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10">
                @if ($post->cover_image)
                    <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @else
                    <x-media-placeholder :title="$post->title" class="w-full h-full" />
                @endif
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-24">
            <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 whitespace-pre-line">{{ $post->body }}</div>
        </div>
    </article>

</x-site-layout>
