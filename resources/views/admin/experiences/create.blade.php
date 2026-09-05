<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">New Experience</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
                <form method="POST" action="{{ route('admin.experiences.store') }}" class="space-y-6">
                    @csrf
                    @include('admin.experiences._form')

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.experiences.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">Create Experience</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
