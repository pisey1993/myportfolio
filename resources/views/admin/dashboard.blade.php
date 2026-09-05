<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Dashboard</h1>
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8 pb-8">
        <div class="max-w-6xl space-y-5">

            @if (session('status'))
                <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            @php
                $cards = [
                    ['label' => 'Projects', 'value' => $stats['projects'], 'route' => 'admin.projects.index', 'color' => 'bg-indigo-50 text-indigo-600', 'icon' => '<rect x="3" y="7" width="18" height="13" rx="1.5"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="3" y1="12" x2="21" y2="12"/>'],
                    ['label' => 'Posts', 'value' => $stats['posts'], 'route' => 'admin.posts.index', 'color' => 'bg-violet-50 text-violet-600', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>'],
                    ['label' => 'Skills', 'value' => $stats['skills'], 'route' => 'admin.skills.index', 'color' => 'bg-amber-50 text-amber-600', 'icon' => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>'],
                    ['label' => 'Unread Messages', 'value' => $stats['unread_messages'], 'route' => 'admin.messages.index', 'color' => 'bg-rose-50 text-rose-600', 'icon' => '<rect x="3" y="5" width="18" height="14" rx="1.5"/><path d="M3 7l9 6 9-6"/>'],
                ];
            @endphp

            <div class="anim-stagger grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($cards as $card)
                    <a href="{{ route($card['route']) }}" class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 hover:shadow-md hover:-translate-y-0.5 transition">
                        <span class="inline-flex w-10 h-10 rounded-xl items-center justify-center {{ $card['color'] }}">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! $card['icon'] !!}</svg>
                        </span>
                        <p class="mt-4 text-2xl font-semibold tracking-tight text-slate-900 leading-none" data-countup="{{ (int) $card['value'] }}">0</p>
                        <p class="text-sm text-slate-500 mt-1">{{ $card['label'] }}</p>
                    </a>
                @endforeach
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-[15px] font-semibold text-slate-900">Recent Messages</h2>
                    <a href="{{ route('admin.messages.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">View all</a>
                </div>
                @if ($recentMessages->isEmpty())
                    <p class="px-5 py-8 text-sm text-slate-500">No messages yet.</p>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach ($recentMessages as $message)
                            <li>
                                <a href="{{ route('admin.messages.show', $message) }}" class="flex items-center justify-between px-5 py-3.5 hover:bg-slate-50 transition">
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">
                                            {{ $message->name }}
                                            @unless ($message->read_at)
                                                <span class="ml-2 inline-block w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            @endunless
                                        </p>
                                        <p class="text-sm text-slate-500">{{ $message->subject ?: \Illuminate\Support\Str::limit($message->message, 60) }}</p>
                                    </div>
                                    <span class="text-xs text-slate-400 shrink-0 ml-4">{{ $message->created_at->diffForHumans() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
