<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Project</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form method="POST" action="{{ route('admin.projects.store') }}" class="space-y-6">
                    @csrf
                    @include('admin.projects._form')

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 rounded-md bg-gray-900 text-white text-sm font-medium hover:bg-gray-700">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
