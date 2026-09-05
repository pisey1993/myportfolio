<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">Experience</h1>
        <a href="{{ route('admin.experiences.create') }}" class="inline-flex items-center px-3 py-1 rounded-lg border border-[#4f46e5] text-[#4f46e5] text-[13px] font-medium hover:bg-[#eef2ff]">
            Add New
        </a>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        @if (session('status'))
            <div class="mb-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden max-w-4xl">
            @if ($experiences->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#64748b]">No experience entries yet. <a href="{{ route('admin.experiences.create') }}" class="text-[#4f46e5] hover:text-[#4338ca]">Add your first one</a>.</p>
            @else
                <table class="min-w-full text-[13px]">
                    <thead>
                        <tr class="border-b border-[#e2e8f0]">
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Role</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Company</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Dates</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @foreach ($experiences as $experience)
                            <tr class="group hover:bg-[#f8fafc]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.experiences.edit', $experience) }}" class="font-medium text-[#4f46e5] hover:text-[#4338ca]">{{ $experience->title }}</a>
                                    <div class="mt-1 text-[13px] text-[#4f46e5] opacity-0 group-hover:opacity-100 transition space-x-1">
                                        <a href="{{ route('admin.experiences.edit', $experience) }}" class="hover:text-[#4338ca] hover:underline">Edit</a>
                                        <span class="text-[#e2e8f0]">|</span>
                                        <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" class="inline" onsubmit="return confirm('Delete this experience entry?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b91c1c] hover:text-[#dc2626] hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-[#64748b] align-top">{{ $experience->company }}</td>
                                <td class="px-4 py-3 text-[#64748b] align-top">{{ $experience->start_label }} — {{ $experience->end_label ?: 'Present' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
