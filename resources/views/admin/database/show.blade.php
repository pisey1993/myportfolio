<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.database.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Database</a>
                <h1 class="text-2xl font-normal text-[#1d2327] font-mono">{{ $table }}</h1>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.database.manage', $table) }}" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">
                    Manage Columns
                </a>
                @if ($primaryKey)
                    <a href="{{ route('admin.database.create', $table) }}" class="inline-flex items-center px-4 py-2 rounded-md bg-[#2271b1] text-white text-sm font-medium hover:bg-[#135e96]">
                        New Row
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-white border-l-4 border-[#00a32a] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                    {{ session('status') }}
                </div>
            @endif

            @if ($isSystem)
                <div class="rounded-md bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-700">
                    This table is used internally by Laravel (sessions, queue, cache, migrations). Editing or deleting rows here can log you out, break scheduled jobs, or corrupt migration state.
                </div>
            @endif

            @unless ($primaryKey)
                <div class="rounded-md bg-gray-50 border border-gray-200 px-4 py-3 text-sm text-gray-600">
                    This table has no single-column primary key, so rows can be viewed but not edited or deleted here.
                </div>
            @endunless

            <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach ($columns as $column)
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">
                                    {{ $column['name'] }}
                                    <span class="normal-case font-normal text-gray-400">({{ $column['type_name'] }})</span>
                                </th>
                            @endforeach
                            @if ($primaryKey)
                                <th class="px-4 py-3"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($rows as $row)
                            <tr>
                                @foreach ($columns as $column)
                                    @php $value = $row->{$column['name']} ?? null; @endphp
                                    <td class="px-4 py-3 text-gray-700 max-w-xs truncate" title="{{ $value }}">
                                        @if (is_null($value))
                                            <span class="text-gray-300 italic">null</span>
                                        @elseif ($value === '')
                                            <span class="text-gray-300 italic">empty</span>
                                        @else
                                            {{ \Illuminate\Support\Str::limit((string) $value, 60) }}
                                        @endif
                                    </td>
                                @endforeach
                                @if ($primaryKey)
                                    <td class="px-4 py-3 text-right whitespace-nowrap space-x-3">
                                        <a href="{{ route('admin.database.edit', [$table, $row->{$primaryKey}]) }}" class="text-[#2271b1] hover:text-[#135e96]">Edit</a>
                                        <form action="{{ route('admin.database.destroy', [$table, $row->{$primaryKey}]) }}" method="POST" class="inline" onsubmit="return confirm('Delete this row?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) + 1 }}" class="px-4 py-8 text-center text-gray-500">No rows.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $rows->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
