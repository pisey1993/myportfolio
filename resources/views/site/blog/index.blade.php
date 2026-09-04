<x-site-layout :title="'Blog — ' . config('app.name')">

    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
        <h1 class="text-3xl font-bold text-gray-900">Blog</h1>
        <p class="mt-3 text-gray-600">Notes on projects, Laravel, and things I'm learning.</p>

        @if ($posts->isEmpty())
            <p class="mt-12 text-gray-500">No posts yet — check back soon.</p>
        @else
            <div class="mt-10 divide-y divide-gray-100">
                @foreach ($posts as $post)
                    <a href="{{ route('blog.show', $post) }}" class="block group py-6">
                        <p class="text-xs text-gray-400 mb-1.5">{{ $post->published_at->format('F j, Y') }}</p>
                        <h2 class="text-lg font-semibold text-gray-900 group-hover:text-indigo-600 transition">{{ $post->title }}</h2>
                        @if ($post->excerpt)
                            <p class="mt-1.5 text-sm text-gray-600">{{ $post->excerpt }}</p>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @endif
    </section>

</x-site-layout>
