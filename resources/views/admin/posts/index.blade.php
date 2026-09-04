<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">Posts</h1>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center px-3 py-1 rounded-[3px] border border-[#2271b1] text-[#2271b1] text-[13px] font-medium hover:bg-[#f0f6fc]">
            Add New
        </a>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        @if (session('status'))
            <div class="mb-4 bg-white border-l-4 border-[#00a32a] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] overflow-hidden">
            @if ($posts->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#646970]">No posts yet. <a href="{{ route('admin.posts.create') }}" class="text-[#2271b1] hover:text-[#135e96]">Write your first one</a>.</p>
            @else
                <table class="min-w-full text-[13px]">
                    <thead>
                        <tr class="border-b border-[#c3c4c7]">
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Title</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Status</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Published</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0f0f1]">
                        @foreach ($posts as $post)
                            <tr class="group hover:bg-[#f6f7f7]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-[#2271b1] hover:text-[#135e96]">{{ $post->title }}</a>
                                    <div class="mt-1 text-[13px] text-[#2271b1] opacity-0 group-hover:opacity-100 transition space-x-1">
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="hover:text-[#135e96] hover:underline">Edit</a>
                                        @if ($post->is_published)
                                            <span class="text-[#dcdcde]">|</span>
                                            <a href="{{ route('blog.show', $post) }}" target="_blank" class="hover:text-[#135e96] hover:underline">View</a>
                                        @endif
                                        <span class="text-[#dcdcde]">|</span>
                                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Delete this post?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b32d2e] hover:text-[#d63638] hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 align-top">
                                    @if ($post->is_published)
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#00a32a]/10 text-[#00a32a]">Published</span>
                                    @else
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#f0f0f1] text-[#646970]">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-[#646970] align-top">{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
