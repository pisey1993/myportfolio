<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">SQL Query</h1>
            <a href="{{ route('admin.database.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Database</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <p class="text-sm text-gray-500">Read-only. Only <code class="font-mono">SELECT</code> statements are allowed, and results are capped at 200 rows.</p>

            <form method="POST" action="{{ route('admin.database.query') }}" class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-6 space-y-4">
                @csrf
                <textarea name="sql" rows="5" placeholder="select * from projects order by created_at desc"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#4f46e5] focus:ring-[#4f46e5] sm:text-sm font-mono">{{ $sql }}</textarea>
                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-md bg-[#4f46e5] text-white text-sm font-medium hover:bg-[#4338ca]">Run Query</button>
                </div>
            </form>

            @if ($error)
                <div class="rounded-xl bg-rose-50 px-4 py-3 text-sm text-rose-700 font-mono whitespace-pre-wrap">{{ $error }}</div>
            @elseif ($results !== null)
                <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-3 border-b border-gray-100 text-sm text-gray-500">
                        {{ count($results) }} row{{ count($results) === 1 ? '' : 's' }} &middot; {{ $elapsed }} ms
                    </div>
                    @if (count($results))
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach (array_keys((array) $results[0]) as $col)
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($results as $row)
                                        <tr>
                                            @foreach ((array) $row as $value)
                                                <td class="px-4 py-3 text-gray-700 max-w-xs truncate" title="{{ $value }}">
                                                    @if (is_null($value))
                                                        <span class="text-gray-300 italic">null</span>
                                                    @else
                                                        {{ \Illuminate\Support\Str::limit((string) $value, 80) }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
