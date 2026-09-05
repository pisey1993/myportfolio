<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">Database</h1>
        <a href="{{ route('admin.database.create-table') }}" class="inline-flex items-center px-3 py-1 rounded-lg border border-[#4f46e5] text-[#4f46e5] text-[13px] font-medium hover:bg-[#eef2ff]">
            Add New
        </a>
        <a href="{{ route('admin.database.query') }}" class="inline-flex items-center px-3 py-1 rounded-lg text-[#4f46e5] text-[13px] font-medium hover:text-[#4338ca] hover:underline">
            SQL Query
        </a>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8 space-y-4">
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

        <p class="text-[13px] text-[#64748b]">
            Connection: <span class="font-medium text-[#0f172a]">{{ config('database.default') }}</span>
            @if (config('database.default') === 'sqlite')
                — <span class="font-mono text-[12px]">{{ config('database.connections.sqlite.database') }}</span>
            @endif
        </p>

        <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden">
            <table class="min-w-full text-[13px]">
                <thead>
                    <tr class="border-b border-[#e2e8f0]">
                        <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Table</th>
                        <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Columns</th>
                        <th class="px-4 py-2 text-left font-semibold text-[#0f172a]">Rows</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @foreach ($tables as $table)
                        <tr class="group hover:bg-[#f8fafc]">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.database.show', $table['name']) }}" class="font-medium text-[#4f46e5] hover:text-[#4338ca] font-mono">{{ $table['name'] }}</a>
                                @if ($table['system'])
                                    <span class="ml-2 inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#d97706]/15 text-[#92400e]">system</span>
                                @endif
                                <div class="mt-1 text-[13px] text-[#4f46e5] opacity-0 group-hover:opacity-100 transition space-x-1">
                                    <a href="{{ route('admin.database.show', $table['name']) }}" class="hover:text-[#4338ca] hover:underline">Browse</a>
                                    <span class="text-[#e2e8f0]">|</span>
                                    <a href="{{ route('admin.database.manage', $table['name']) }}" class="hover:text-[#4338ca] hover:underline">Manage</a>
                                    @if ($table['name'] !== 'migrations')
                                        <span class="text-[#e2e8f0]">|</span>
                                        <form action="{{ route('admin.database.drop-table', $table['name']) }}" method="POST" class="inline" onsubmit="return confirm('Drop table \'{{ $table['name'] }}\'? This permanently deletes the table and all its data.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#b91c1c] hover:text-[#dc2626] hover:underline">Drop</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[#64748b] align-top">{{ $table['columns'] }}</td>
                            <td class="px-4 py-3 text-[#64748b] align-top">{{ number_format($table['rows']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
