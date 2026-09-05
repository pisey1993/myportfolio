<x-site-layout :title="'Projects — ' . \App\Models\SiteSetting::current()->headline">

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
        </div>
        <div class="anim-stagger max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-24 pb-12">
            <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-1">Portfolio</p>
            <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white">Projects</h1>
            <p class="mt-3 text-slate-600 dark:text-slate-400 max-w-xl">A selection of things I've built.</p>
        </div>
    </section>

    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        @if ($projects->isEmpty())
            <p class="text-slate-500">No projects yet — check back soon.</p>
        @else
            <div class="anim-stagger grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="group block rounded-2xl border border-slate-200 dark:border-white/10 shadow-sm overflow-hidden hover:border-slate-300 dark:hover:border-white/20 hover:shadow-md hover:-translate-y-1 transition duration-300 bg-white dark:bg-slate-900">
                        <div class="aspect-video overflow-hidden relative">
                            @if ($project->image)
                                <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <x-media-placeholder :title="$project->title" class="w-full h-full group-hover:scale-105 transition duration-500" />
                            @endif
                            @if ($project->is_featured)
                                <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded-full bg-slate-900/70 text-white backdrop-blur">Featured</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-slate-900 dark:text-white group-hover:text-fuchsia-600 dark:group-hover:text-fuchsia-400 transition">{{ $project->title }}</h3>
                            <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{{ $project->summary }}</p>
                            @if ($project->tech_stack)
                                <div class="mt-4 flex flex-wrap gap-1.5">
                                    @foreach ($project->techStackList() as $tech)
                                        <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-white/10">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

</x-site-layout>
