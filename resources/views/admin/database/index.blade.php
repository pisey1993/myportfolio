<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">Database</h1>
        <a href="{{ route('admin.database.create-table') }}" class="inline-flex items-center px-3 py-1 rounded-[3px] border border-[#2271b1] text-[#2271b1] text-[13px] font-medium hover:bg-[#f0f6fc]">
            Add New
        </a>
        <a href="{{ route('admin.database.query') }}" class="inline-flex items-center px-3 py-1 rounded-[3px] text-[#2271b1] text-[13px] font-medium hover:text-[#135e96] hover:underline">
            SQL Query
        </a>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8 space-y-4">
        @if (session('status'))
            <div class="bg-white border-l-4 border-[#00a32a] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-white border-l-4 border-[#d63638] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                {{ $errors->first() }}
            </div>
        @endif

        <p class="text-[13px] text-[#646970]">
            Connection: <span class="font-medium text-[#1d2327]">{{ config('database.default') }}</span>
            @if (config('database.default') === 'sqlite')
                — <span class="font-mono text-[12px]">{{ config('database.connections.sqlite.database') }}</span>
            @endif
        </p>

        <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] overflow-hidden">
            <table class="min-w-full text-[13px]">
                <thead>
                    <tr class="border-b border-[#c3c4c7]">
                        <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Table</th>
                        <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Columns</th>
                        <th class="px-4 py-2 text-left font-semibold text-[#1d2327]">Rows</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0f0f1]">
                    @foreach ($tables as $table)
                        <tr class="group hover:bg-[#f6f7f7]">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.database.show', $table['name']) }}" class="font-medium text-[#2271b1] hover:text-[#135e96] font-mono">{{ $table['name'] }}</a>
                                @if ($table['system'])
                                    <span class="ml-2 inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#dba617]/15 text-[#8a6d1a]">system</span>
                                @endif
                                <div class="mt-1 text-[13px] text-[#2271b1] opacity-0 group-hover:opacity-100 transition space-x-1">
                                    <a href="{{ route('admin.database.show', $table['name']) }}" class="hover:text-[#135e96] hover:underline">Browse</a>
                                    <span class="text-[#dcdcde]">|</span>
                                    <a href="{{ route('admin.database.manage', $table['name']) }}" class="hover:text-[#135e96] hover:underline">Manage</a>
                                    @if ($table['name'] !== 'migrations')
                                        <span class="text-[#dcdcde]">|</span>
                                        <form action="{{ route('admin.database.drop-table', $table['name']) }}" method="POST" class="inline" onsubmit="return confirm('Drop table \'{{ $table['name'] }}\'? This permanently deletes the table and all its data.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b32d2e] hover:text-[#d63638] hover:underline">Drop</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#646970] align-top">{{ $table['columns'] }}</td>
                            <td class="px-4 py-3 text-[#646970] align-top">{{ number_format($table['rows']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
