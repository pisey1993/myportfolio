@php
    $unreadMessages = \App\Models\ContactMessage::whereNull('read_at')->count();

    $navItems = [
        ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
        ['route' => 'admin.experiences.index', 'pattern' => 'admin.experiences.*', 'label' => 'Experience', 'icon' => 'clock'],
        ['route' => 'admin.projects.index', 'pattern' => 'admin.projects.*', 'label' => 'Projects', 'icon' => 'briefcase'],
        ['route' => 'admin.posts.index', 'pattern' => 'admin.posts.*', 'label' => 'Posts', 'icon' => 'document'],
        ['route' => 'admin.skills.index', 'pattern' => 'admin.skills.*', 'label' => 'Skills', 'icon' => 'chart'],
        ['route' => 'admin.messages.index', 'pattern' => 'admin.messages.*', 'label' => 'Messages', 'icon' => 'envelope', 'badge' => $unreadMessages],
        ['route' => 'admin.database.index', 'pattern' => 'admin.database.*', 'label' => 'Database', 'icon' => 'database'],
        ['route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'label' => 'Settings', 'icon' => 'settings'],
    ];
@endphp

@php
    $icon = function (string $name, string $class = 'w-[18px] h-[18px]') {
        $paths = [
            'dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
            'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="1.5"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="3" y1="12" x2="21" y2="12"/>',
            'clock' => '<circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15.5 14"/>',
            'document' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>',
            'chart' => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>',
            'envelope' => '<rect x="3" y="5" width="18" height="14" rx="1.5"/><path d="M3 7l9 6 9-6"/>',
            'database' => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/>',
            'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
            'collapse' => '<polyline points="11 17 6 12 11 7"/><polyline points="18 17 13 12 18 7"/>',
        ];

        return '<svg class="'.$class.' shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">'.($paths[$name] ?? '').'</svg>';
    };
@endphp

<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden"></div>

<aside
    x-data="{ collapsed: false }"
    :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', collapsed ? 'lg:w-[76px]' : 'lg:w-64']"
    class="anim-fade-in fixed top-0 bottom-0 left-0 z-50 w-64 bg-slate-900 flex flex-col shrink-0 transform transition-[transform,width] duration-200 ease-in-out lg:translate-x-0 lg:static"
>
    <a href="{{ route('admin.dashboard') }}" class="h-16 shrink-0 flex items-center gap-2.5 px-5 border-b border-white/5 overflow-hidden whitespace-nowrap">
        <span class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center shrink-0">
            <svg class="w-[18px] h-[18px] text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/><path d="M3 12h18"/></svg>
        </span>
        <span x-show="!collapsed" x-cloak class="text-[15px] font-semibold text-white">{{ config('app.name', 'Admin') }}</span>
    </a>

    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-4 px-3 space-y-1">
        @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['pattern']); @endphp
            <a href="{{ route($item['route']) }}"
                :title="collapsed ? '{{ $item['label'] }}' : ''"
                class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13.5px] font-medium transition whitespace-nowrap
                    {{ $active
                        ? 'bg-indigo-600 text-white shadow-sm shadow-indigo-900/40'
                        : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                {!! $icon($item['icon']) !!}
                <span x-show="!collapsed" x-cloak class="flex-1">{{ $item['label'] }}</span>
                @if (! empty($item['badge']))
                    <span x-show="!collapsed" class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 rounded-full text-[11px] font-semibold bg-rose-500 text-white">
                        {{ $item['badge'] }}
                    </span>
                    <span x-show="collapsed" x-cloak class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500 ring-2 ring-slate-900"></span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="border-t border-white/5 shrink-0 p-3">
        <button @click="collapsed = !collapsed" class="hidden lg:flex w-full items-center gap-3 px-3 py-2.5 rounded-lg text-[13.5px] font-medium text-slate-500 hover:bg-white/5 hover:text-white transition">
            <svg class="w-[18px] h-[18px] shrink-0 transition-transform" :class="collapsed ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">{!! '<polyline points="11 17 6 12 11 7"/><polyline points="18 17 13 12 18 7"/>' !!}</svg>
            <span x-show="!collapsed" x-cloak>Collapse menu</span>
        </button>
    </div>
</aside>
