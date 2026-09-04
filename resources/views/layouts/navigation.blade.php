@php
    $unreadMessages = \App\Models\ContactMessage::whereNull('read_at')->count();

    $navItems = [
        ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard'],
        ['route' => 'admin.projects.index', 'pattern' => 'admin.projects.*', 'label' => 'Projects', 'icon' => 'briefcase'],
        ['route' => 'admin.posts.index', 'pattern' => 'admin.posts.*', 'label' => 'Posts', 'icon' => 'document'],
        ['route' => 'admin.skills.index', 'pattern' => 'admin.skills.*', 'label' => 'Skills', 'icon' => 'chart'],
        ['route' => 'admin.messages.index', 'pattern' => 'admin.messages.*', 'label' => 'Messages', 'icon' => 'envelope', 'badge' => $unreadMessages],
        ['route' => 'admin.database.index', 'pattern' => 'admin.database.*', 'label' => 'Database', 'icon' => 'database'],
        ['route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'label' => 'Settings', 'icon' => 'settings'],
    ];
@endphp

@php
    $icon = function (string $name, string $class = 'w-4 h-4') {
        $paths = [
            'dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
            'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="1"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="3" y1="12" x2="21" y2="12"/>',
            'document' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><line x1="8" y1="13" x2="16" y2="13"/><line x1="8" y1="17" x2="16" y2="17"/>',
            'chart' => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>',
            'envelope' => '<rect x="3" y="5" width="18" height="14" rx="1"/><path d="M3 7l9 6 9-6"/>',
            'database' => '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/><path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/>',
            'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
            'collapse' => '<polyline points="11 17 6 12 11 7"/><polyline points="18 17 13 12 18 7"/>',
        ];

        return '<svg class="'.$class.' shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">'.($paths[$name] ?? '').'</svg>';
    };
@endphp

<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 top-8 bg-gray-900/50 z-40 lg:hidden"></div>

<aside
    x-data="{ collapsed: false }"
    :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', collapsed ? 'lg:w-11' : 'lg:w-[180px]']"
    class="fixed top-8 bottom-0 left-0 z-50 w-[180px] bg-[#1d2327] flex flex-col shrink-0 transform transition-[transform,width] duration-200 ease-in-out lg:translate-x-0 lg:static"
>
    <nav class="flex-1 overflow-y-auto overflow-x-hidden py-2">
        @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['pattern']); @endphp
            <a href="{{ route($item['route']) }}"
                :title="collapsed ? '{{ $item['label'] }}' : ''"
                class="flex items-center gap-2.5 px-3.5 py-2.5 text-[13px] font-medium border-l-4 transition whitespace-nowrap
                    {{ $active
                        ? 'bg-[#2271b1] border-l-white text-white'
                        : 'border-l-transparent text-[#f0f0f1]/70 hover:bg-[#2c3338] hover:text-[#72aee6]' }}">
                {!! $icon($item['icon']) !!}
                <span x-show="!collapsed" x-cloak class="flex-1">{{ $item['label'] }}</span>
                @if (! empty($item['badge']))
                    <span x-show="!collapsed" class="inline-flex items-center justify-center min-w-[1.1rem] h-[1.1rem] px-1 rounded-full text-[10px] font-semibold bg-[#d63638] text-white">
                        {{ $item['badge'] }}
                    </span>
                    <span x-show="collapsed" x-cloak class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#d63638]"></span>
                @endif
            </a>
        @endforeach
    </nav>

    <div class="border-t border-white/10 shrink-0">
        <a href="{{ route('home') }}" target="_blank"
            class="flex items-center gap-2.5 px-3.5 py-2.5 text-[13px] font-medium text-[#f0f0f1]/70 hover:bg-[#2c3338] hover:text-[#72aee6] transition whitespace-nowrap">
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            <span x-show="!collapsed" x-cloak>Visit Site</span>
        </a>
        <button @click="collapsed = !collapsed" class="hidden lg:flex w-full items-center gap-2.5 px-3.5 py-2.5 text-[13px] font-medium text-[#f0f0f1]/50 hover:bg-[#2c3338] hover:text-[#72aee6] transition">
            <svg class="w-4 h-4 shrink-0 transition-transform" :class="collapsed ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! '<polyline points="11 17 6 12 11 7"/><polyline points="18 17 13 12 18 7"/>' !!}</svg>
            <span x-show="!collapsed" x-cloak>Collapse menu</span>
        </button>
    </div>
</aside>
