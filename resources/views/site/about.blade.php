<x-site-layout :title="'About — ' . config('app.name')">

    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
        <h1 class="text-3xl font-bold text-gray-900">About</h1>
        <div class="mt-6 prose prose-gray max-w-none text-gray-700 space-y-4">
            <p>
                Hi, I'm {{ config('app.name', 'Pisey') }}. I build web applications with Laravel,
                focused on practical tools that solve real business problems — from CRM systems
                to reporting dashboards.
            </p>
            <p>
                Outside of work, I like exploring new tools in the Laravel ecosystem and
                writing about what I learn along the way.
            </p>
        </div>
    </section>

    @if ($skills->isNotEmpty())
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-gray-100">
        <h2 class="text-2xl font-semibold text-gray-900 mb-8">Skills</h2>
        <div class="space-y-8">
            @foreach ($skills as $category => $items)
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">{{ $category }}</h3>
                    <div class="space-y-3">
                        @foreach ($items as $skill)
                            <div>
                                <div class="flex justify-between text-sm text-gray-700 mb-1">
                                    <span>{{ $skill->name }}</span>
                                    <span class="text-gray-400">{{ $skill->level }}%</span>
                                </div>
                                <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gray-900 rounded-full" style="width: {{ $skill->level }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

</x-site-layout>
