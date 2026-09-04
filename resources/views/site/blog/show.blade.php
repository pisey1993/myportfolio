<x-site-layout :title="$post->title . ' — ' . config('app.name')" :description="$post->excerpt">

    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24">
        <a href="{{ route('blog.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; All posts</a>

        <p class="mt-4 text-xs text-gray-400">{{ $post->published_at->format('F j, Y') }}</p>
        <h1 class="mt-2 text-3xl font-bold text-gray-900">{{ $post->title }}</h1>

        @if ($post->cover_image)
            <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="mt-8 rounded-lg border border-gray-200 w-full object-cover">
        @endif

        <div class="mt-8 prose prose-gray max-w-none text-gray-700 whitespace-pre-line">{{ $post->body }}</div>
    </article>

</x-site-layout>
