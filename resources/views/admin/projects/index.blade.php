<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center px-3 py-1 rounded-lg border border-[#4f46e5] text-[#4f46e5] text-[13px] font-medium hover:bg-[#eef2ff]">
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
            @if ($projects->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#64748b]">No projects yet. <a href="{{ route('admin.projects.create') }}" class="text-[#4f46e5] hover:text-[#4338ca]">Create your first one</a>.</p>
            @else
                <table class="min-w-full text-[13px]">
                    <thead>
                        <tr class="border-b border-[#e2e8f0]">
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Title</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Featured</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @foreach ($projects as $project)
                            <tr class="group hover:bg-[#f8fafc]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="font-medium text-[#4f46e5] hover:text-[#4338ca]">{{ $project->title }}</a>
                                    <div class="text-[#64748b]">{{ $project->summary }}</div>
                                    <div class="mt-1 text-[13px] text-[#4f46e5] opacity-0 group-hover:opacity-100 transition space-x-1">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="hover:text-[#4338ca] hover:underline">Edit</a>
                                        <span class="text-[#e2e8f0]">|</span>
                                        <a href="{{ route('projects.show', $project) }}" target="_blank" class="hover:text-[#4338ca] hover:underline">View</a>
                                        <span class="text-[#e2e8f0]">|</span>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Delete this project?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b91c1c] hover:text-[#dc2626] hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-[#0f172a] align-top">{{ $project->is_featured ? 'Yes' : '—' }}</td>
                                <td class="px-4 py-3 text-[#0f172a] align-top">{{ $project->sort_order }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
