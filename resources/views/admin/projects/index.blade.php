<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center px-3 py-1 rounded-[3px] border border-[#2271b1] text-[#2271b1] text-[13px] font-medium hover:bg-[#f0f6fc]">
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
            @if ($projects->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#646970]">No projects yet. <a href="{{ route('admin.projects.create') }}" class="text-[#2271b1] hover:text-[#135e96]">Create your first one</a>.</p>
            @else
                <table class="min-w-full text-[13px]">
                    <thead>
                        <tr class="border-b border-[#c3c4c7]">
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Title</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Featured</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0f0f1]">
                        @foreach ($projects as $project)
                            <tr class="group hover:bg-[#f6f7f7]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="font-medium text-[#2271b1] hover:text-[#135e96]">{{ $project->title }}</a>
                                    <div class="text-[#646970]">{{ $project->summary }}</div>
                                    <div class="mt-1 text-[13px] text-[#2271b1] opacity-0 group-hover:opacity-100 transition space-x-1">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="hover:text-[#135e96] hover:underline">Edit</a>
                                        <span class="text-[#dcdcde]">|</span>
                                        <a href="{{ route('projects.show', $project) }}" target="_blank" class="hover:text-[#135e96] hover:underline">View</a>
                                        <span class="text-[#dcdcde]">|</span>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b32d2e] hover:text-[#d63638] hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-[#1d2327] align-top">{{ $project->is_featured ? 'Yes' : '—' }}</td>
                                <td class="px-4 py-3 text-[#1d2327] align-top">{{ $project->sort_order }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
