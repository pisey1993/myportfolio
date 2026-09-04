<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Messages</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                @if ($messages->isEmpty())
                    <p class="px-6 py-8 text-sm text-gray-500">No messages yet.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($messages as $message)
                            <li>
                                <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between px-6 py-4 hover:bg-gray-50">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $message->name }}
                                            <span class="text-gray-400 font-normal">&lt;{{ $message->email }}&gt;</span>
                                            @unless ($message->read_at)
                                                <span class="ml-2 inline-block w-2 h-2 rounded-full bg-indigo-500"></span>
                                            @endunless
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 80) }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400 shrink-0 ml-4">{{ $message->created_at->diffForHumans() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
