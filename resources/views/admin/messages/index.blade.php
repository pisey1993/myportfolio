<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">Messages</h1>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        @if (session('status'))
            <div class="mb-4 bg-white border-l-4 border-[#00a32a] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] overflow-hidden max-w-5xl">
            @if ($messages->isEmpty())
                <p class="px-4 py-8 text-[13px] text-[#646970]">No messages yet.</p>
            @else
                <ul class="divide-y divide-[#f0f0f1] text-[13px]">
                    @foreach ($messages as $message)
                        <li>
                            <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between px-4 py-3 hover:bg-[#f6f7f7]">
                                <div>
                                    <p class="font-medium text-[#1d2327]">
                                        {{ $message->name }}
                                        <span class="text-[#8c8f94] font-normal">&lt;{{ $message->email }}&gt;</span>
                                        @unless ($message->read_at)
                                            <span class="ml-2 inline-block w-2 h-2 rounded-full bg-[#d63638]"></span>
                                        @endunless
                                    </p>
                                    <p class="text-[#646970]">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 80) }}</p>
                                </div>
                                <span class="text-[12px] text-[#8c8f94] shrink-0 ml-4">{{ $message->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
