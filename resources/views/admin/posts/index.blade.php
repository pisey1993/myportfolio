<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-3 py-1 rounded-lg border border-[#4f46e5] text-[#4f46e5] text-[13px] font-medium hover:bg-[#eef2ff]">
            Add New
        </a>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        @if (session('status'))
            <div class="mb-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden">
            @if ($posts->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#64748b]">No posts yet. <a href="{{ route('admin.posts.create') }}" class="text-[#4f46e5] hover:text-[#4338ca]">Write your first one</a>.</p>
            @else
                <table class="min-w-full text-[13px]">
                    <thead>
                        <tr class="border-b border-[#e2e8f0]">
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Title</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Status</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Published</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @foreach ($posts as $post)
                            <tr class="group hover:bg-[#f8fafc]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-[#4f46e5] hover:text-[#4338ca]">{{ $post->title }}</a>
                                    <div class="mt-1 text-[13px] text-[#4f46e5] opacity-0 group-hover:opacity-100 transition space-x-1">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="hover:text-[#4338ca] hover:underline">Edit</a>
                                        @if ($post->is_published)
                                            <span class="text-[#e2e8f0]">|</span>
                                            <a href="{{ route('blog.show', $post) }}" target="_blank" class="hover:text-[#4338ca] hover:underline">View</a>
                                        @endif
                                        <span class="text-[#e2e8f0]">|</span>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b91c1c] hover:text-[#dc2626] hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-top">
                                    @if ($post->is_published)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#059669]/10 text-[#059669]">Published</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#f1f5f9] text-[#64748b]">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-[#64748b] align-top">{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
