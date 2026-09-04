<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">
            New row in <span class="font-mono">{{ $table }}</span>
        </h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] p-6">
                <form method="POST" action="{{ route('admin.database.store', $table) }}" class="space-y-5">
                    @csrf
                    @include('admin.database._fields')

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('admin.database.show', $table) }}" class="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 rounded-md bg-[#2271b1] text-white text-sm font-medium hover:bg-[#135e96]">Create Row</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
