<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.database.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Database</a>
                <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">
                    Manage <span class="font-mono">{{ $table }}</span>
                </h1>
            </div>
            <a href="{{ route('admin.database.show', $table) }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">
                Browse Rows
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="rounded-xl bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($isSystem)
                <div class="rounded-md bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-700">
                    This table is used internally by Laravel. Adding or dropping columns here can break sessions, queued jobs, or caching.
                </div>
            @endif

            <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <span class="font-medium text-gray-900">Columns</span>
                    <span class="text-xs text-gray-400">
                        @if ($sampleRow)
                            Value column shows the most recent row out of {{ number_format($rowCount) }}.
                        @else
                            No rows yet — nothing to preview.
                        @endif
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nullable</th>
                                <th class="px-6 py-2 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                                <th class="px-6 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($columns as $column)
                                @php $value = $sampleRow->{$column['name']} ?? null; @endphp
                                <tr>
                                    <td class="px-6 py-3 font-mono text-gray-900 whitespace-nowrap">
                                        {{ $column['name'] }}
                                        @if ($column['name'] === $primaryKey)
                                            <span class="ml-2 inline-flex px-2 py-0.5 rounded text-xs font-medium bg-[#4f46e5]/10 text-[#4f46e5]">primary</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $column['type_name'] }}</td>
                                    <td class="px-6 py-3 text-gray-500 whitespace-nowrap">{{ $column['nullable'] ? 'Yes' : 'No' }}</td>
                                    <td class="px-6 py-3 text-gray-700 max-w-xs truncate font-mono" title="{{ $value }}">
                                        @if (! $sampleRow)
                                            <span class="text-gray-300 italic">—</span>
                                        @elseif (is_null($value))
                                            <span class="text-gray-300 italic">null</span>
                                        @elseif ($value === '')
                                            <span class="text-gray-300 italic">empty</span>
                                        @else
                                            {{ \Illuminate\Support\Str::limit((string) $value, 50) }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-right whitespace-nowrap">
                                        @unless ($column['name'] === $primaryKey)
                                            <form action="{{ route('admin.database.columns.destroy', [$table, $column['name']]) }}" method="POST" onsubmit="return confirm('Drop column \'{{ $column['name'] }}\'? Any data in it will be lost.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">Drop</button>
                                            </form>
                                        @endunless
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6">
                <h3 class="font-medium text-gray-900 mb-4">Add a column</h3>
                <form method="POST" action="{{ route('admin.database.columns.store', $table) }}" class="grid grid-cols-12 gap-3 items-start">
                    @csrf
                    <div class="col-span-3">
                        <input type="text" name="name" placeholder="field_name" required
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4f46e5] focus:ring-[#4f46e5] text-sm font-mono">
                    </div>
                    <div class="col-span-3">
                        <select name="type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4f46e5] focus:ring-[#4f46e5] text-sm">
                            @foreach ($types as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3">
                        <input type="text" name="default" placeholder="default (optional)"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4f46e5] focus:ring-[#4f46e5] text-sm font-mono">
                    </div>
                    <div class="col-span-2 flex items-center gap-2 pt-2">
                        <input type="checkbox" name="nullable" value="1" checked class="rounded border-gray-300 text-[#4f46e5] focus:ring-[#4f46e5]">
                        <label class="text-sm text-gray-600">nullable</label>
                    </div>
                    <div class="col-span-12 flex justify-end pt-2">
                        <button type="submit" class="px-5 py-2 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">Add Column</button>
                    </div>
                </form>
            </div>

            @if ($table !== 'migrations')
                <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6 border border-red-100">
                    <h3 class="font-medium text-red-700 mb-2">Danger zone</h3>
                    <p class="text-sm text-gray-500 mb-4">Permanently delete this table and all of its data. This cannot be undone.</p>
                    <form action="{{ route('admin.database.drop-table', $table) }}" method="POST" onsubmit="return confirm('Drop table \'{{ $table }}\'? This permanently deletes the table and all its data.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-md border border-red-300 text-red-700 text-sm font-medium hover:bg-red-50">Drop Table</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
