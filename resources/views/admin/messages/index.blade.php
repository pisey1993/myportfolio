<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-[#0f172a]">Messages</h1>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        @if (session('status'))
            <div class="mb-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden max-w-5xl">
            @if ($messages->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#64748b]">No messages yet.</p>
            @else
                <ul class="divide-y divide-[#f1f5f9] text-[13px]">
                    @foreach ($messages as $message)
                        <li>
                            <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between px-4 py-3 hover:bg-[#f8fafc]">
                                <div>
                                    <p class="font-medium text-[#0f172a]">
                                        {{ $message->name }}
                                        <span class="text-[#94a3b8] font-normal">&lt;{{ $message->email }}&gt;</span>
                                        @unless ($message->read_at)
                                            <span class="ml-2 inline-block w-2 h-2 rounded-full bg-[#dc2626]"></span>
                                        @endunless
                                    </p>
                                    <p class="text-[#64748b]">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 80) }}</p>
                                </div>
                                <span class="text-[12px] text-[#94a3b8] shrink-0 ml-4">{{ $message->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
