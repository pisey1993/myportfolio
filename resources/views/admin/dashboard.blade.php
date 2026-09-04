<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">Dashboard</h1>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        <div class="max-w-6xl space-y-5">

            @if (session('status'))
                <div class="bg-white border-l-4 border-[#00a32a] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                    {{ session('status') }}
                </div>
            @endif

            @php
                $cards = [
                    ['label' => 'Projects', 'value' => $stats['projects'], 'route' => 'admin.projects.index', 'icon' => '<rect x="3" y="7" width="18" height="13" rx="1"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="3" y1="12" x2="21" y2="12"/>'],
                    ['label' => 'Posts', 'value' => $stats['posts'], 'route' => 'admin.posts.index', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>'],
                    ['label' => 'Skills', 'value' => $stats['skills'], 'route' => 'admin.skills.index', 'icon' => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>'],
                    ['label' => 'Unread Messages', 'value' => $stats['unread_messages'], 'route' => 'admin.messages.index', 'icon' => '<rect x="3" y="5" width="18" height="14" rx="1"/><path d="M3 7l9 6 9-6"/>'],
                ];
            @endphp

            <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)]">
                <div class="px-4 py-3 border-b border-[#c3c4c7]">
                    <h2 class="text-[14px] font-semibold text-[#1d2327]">At a Glance</h2>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 divide-x divide-[#f0f0f1]">
                    @foreach ($cards as $card)
                        <a href="{{ route($card['route']) }}" class="flex items-center gap-3 px-4 py-5 hover:bg-[#f6f7f7] transition">
                            <svg class="w-7 h-7 text-[#8c8f94] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">{!! $card['icon'] !!}</svg>
                            <div>
                                <p class="text-2xl font-normal text-[#1d2327] leading-none">{{ $card['value'] }}</p>
                                <p class="text-[13px] text-[#2271b1] mt-1">{{ $card['label'] }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)]">
                <div class="px-4 py-3 border-b border-[#c3c4c7] flex items-center justify-between">
                    <h2 class="text-[14px] font-semibold text-[#1d2327]">Recent Messages</h2>
                    <a href="{{ route('admin.messages.index') }}" class="text-[13px] text-[#2271b1] hover:text-[#135e96]">View all</a>
                </div>
                @if ($recentMessages->isEmpty())
                    <p class="px-4 py-6 text-[13px] text-[#646970]">No messages yet.</p>
                @else
                    <ul class="divide-y divide-[#f0f0f1]">
                        @foreach ($recentMessages as $message)
                            <li>
                                <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between px-4 py-3 hover:bg-[#f6f7f7]">
                                    <div>
                                        <p class="text-[13px] font-medium text-[#1d2327]">
                                            {{ $message->name }}
                                            @unless ($message->read_at)
                                                <span class="ml-2 inline-block w-2 h-2 rounded-full bg-[#d63638]"></span>
                                            @endunless
                                        </p>
                                        <p class="text-[13px] text-[#646970]">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 60) }}</p>
                                    </div>
                                    <span class="text-[12px] text-[#8c8f94] shrink-0 ml-4">{{ $message->created_at->diffForHumans() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
