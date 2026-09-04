<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">New Table</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] p-6">
                <form method="POST" action="{{ route('admin.database.store-table') }}"
                    x-data="{
                        columns: {{ old('columns') ? json_encode(old('columns')) : '[{name: \'\', type: \'string\', nullable: false, default: \'\'}]' }}
                    }"
                    class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Table name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. testimonials"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm font-mono">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-xs text-gray-400">An auto-incrementing <span class="font-mono">id</span> primary key is added automatically.</p>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-gray-700">Columns</label>
                            <button type="button" @click="columns.push({name: '', type: 'string', nullable: false, default: ''})"
                                class="text-sm font-medium text-[#2271b1] hover:text-[#135e96]">+ Add column</button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(column, index) in columns" :key="index">
                                <div class="grid grid-cols-12 gap-2 items-start bg-gray-50 rounded-md p-3">
                                    <div class="col-span-3">
                                        <input type="text" :name="`columns[${index}][name]`" x-model="column.name" placeholder="field_name" required
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] text-sm font-mono">
                                    </div>
                                    <div class="col-span-3">
                                        <select :name="`columns[${index}][type]`" x-model="column.type"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] text-sm">
                                            @foreach ($types as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-3">
                                        <input type="text" :name="`columns[${index}][default]`" x-model="column.default" placeholder="default (optional)"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] text-sm font-mono">
                                    </div>
                                    <div class="col-span-2 flex items-center gap-2 pt-2">
                                        <input type="checkbox" :name="`columns[${index}][nullable]`" value="1" x-model="column.nullable"
                                            class="rounded border-gray-300 text-[#2271b1] focus:ring-[#2271b1]">
                                        <label class="text-sm text-gray-600">nullable</label>
                                    </div>
                                    <div class="col-span-1 pt-1 text-right">
                                        <button type="button" @click="columns.splice(index, 1)" x-show="columns.length > 1" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        @error('columns')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="timestamps" id="timestamps" value="1" {{ old('timestamps', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-[#2271b1] focus:ring-[#2271b1]">
                        <label for="timestamps" class="text-sm text-gray-700">Add <span class="font-mono">created_at</span> / <span class="font-mono">updated_at</span> timestamps</label>
                    </div>

                    <div class="flex justify-end gap-3 pt-2 border-t border-gray-100">
                        <a href="{{ route('admin.database.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 rounded-md bg-[#2271b1] text-white text-sm font-medium hover:bg-[#135e96]">Create Table</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
