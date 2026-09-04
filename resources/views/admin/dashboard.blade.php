<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('status'))
                <div class="rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.projects.index') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Projects</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['projects'] }}</p>
                </a>
                <a href="{{ route('admin.posts.index') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Posts</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['posts'] }}</p>
                </a>
                <a href="{{ route('admin.skills.index') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Skills</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['skills'] }}</p>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition">
                    <p class="text-sm text-gray-500">Unread Messages</p>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['unread_messages'] }}</p>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-medium text-gray-900">Recent Messages</h3>
                    <a href="{{ route('admin.messages.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">View all</a>
                </div>
                @if ($recentMessages->isEmpty())
                    <p class="px-6 py-8 text-sm text-gray-500">No messages yet.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach ($recentMessages as $message)
                            <li>
                                <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between px-6 py-4 hover:bg-gray-50">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $message->name }}
                                            @unless ($message->read_at)
                                                <span class="ml-2 inline-block w-2 h-2 rounded-full bg-indigo-500"></span>
                                            @endunless
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 60) }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
