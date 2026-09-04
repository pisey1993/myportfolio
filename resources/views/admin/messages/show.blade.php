<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Message from {{ $message->name }}</h2>
            <a href="{{ route('admin.messages.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; Back to messages</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <dl class="grid sm:grid-cols-2 gap-4 mb-6 pb-6 border-b border-gray-100">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">From</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $message->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="mailto:{{ $message->email }}" class="text-indigo-600 hover:text-indigo-800">{{ $message->email }}</a>
                        </dd>
                    </div>
                    @if ($message->subject)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-gray-500 uppercase">Subject</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $message->subject }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Received</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $message->created_at->format('F j, Y g:i A') }}</dd>
                    </div>
                </dl>

                <p class="text-sm text-gray-800 whitespace-pre-line">{{ $message->message }}</p>

                <div class="mt-8 flex justify-between items-center">
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject ?: 'Your message' }}"
                        class="inline-flex items-center px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-medium hover:bg-gray-700">
                        Reply by Email
                    </a>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
