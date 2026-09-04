<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">Skills</h1>
        <a href="{{ route('admin.skills.create') }}" class="inline-flex items-center px-3 py-1 rounded-[3px] border border-[#2271b1] text-[#2271b1] text-[13px] font-medium hover:bg-[#f0f6fc]">
            Add New
        </a>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        @if (session('status'))
            <div class="mb-4 bg-white border-l-4 border-[#00a32a] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] overflow-hidden max-w-4xl">
            @if ($skills->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#646970]">No skills yet.</p>
            @else
                <table class="min-w-full text-[13px]">
                    <thead>
                        <tr class="border-b border-[#c3c4c7]">
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Name</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Category</th>
                            <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Level</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f0f0f1]">
                        @foreach ($skills as $skill)
                            <tr class="group hover:bg-[#f6f7f7]">
                                <td class="px-4 py-3">
                                    <a href="{{ route('admin.skills.edit', $skill) }}" class="font-medium text-[#2271b1] hover:text-[#135e96]">{{ $skill->name }}</a>
                                    <div class="mt-1 text-[13px] text-[#2271b1] opacity-0 group-hover:opacity-100 transition space-x-1">
                                        <a href="{{ route('admin.skills.edit', $skill) }}" class="hover:text-[#135e96] hover:underline">Edit</a>
                                        <span class="text-[#dcdcde]">|</span>
                                        <form action="{{ route('admin.skills.destroy', $skill) }}" method="POST" class="inline" onsubmit="return confirm('Delete this skill?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b32d2e] hover:text-[#d63638] hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-[#646970] align-top">{{ $skill->category }}</td>
                                <td class="px-4 py-3 text-[#646970] align-top">{{ $skill->level }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
