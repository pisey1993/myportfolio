<x-site-layout :title="$project->title . ' — ' . \App\Models\SiteSetting::current()->headline" :description="$project->summary">

    <article>
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
            </div>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 pb-8">
                <a href="{{ route('projects.index') }}" class="text-sm text-slate-500 hover:text-slate-900 dark:hover:text-white">&larr; All projects</a>

                <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">{{ $project->title }}</h1>
                <p class="mt-3 text-lg text-slate-600 dark:text-slate-400">{{ $project->summary }}</p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($project->project_url)
                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="inline-flex items-center px-5 py-2.5 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:from-pink-500 hover:to-fuchsia-400 transition">
                            Live site &#8599;
                        </a>
                    @endif
                    @if ($project->repo_url)
                        <a href="{{ $project->repo_url }}" target="_blank" rel="noopener" class="inline-flex items-center px-5 py-2.5 rounded-full border border-slate-300 dark:border-white/20 text-slate-900 dark:text-white text-sm font-medium hover:bg-slate-100 dark:hover:bg-white/5 transition">
                            Source code &#8599;
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="aspect-video rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10">
                @if ($project->image)
                    <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                @else
                    <x-media-placeholder :title="$project->title" class="w-full h-full" />
                @endif
            </div>
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-24">
            @if ($project->tech_stack)
                <div class="flex flex-wrap gap-2 mb-8">
                    @foreach ($project->techStackList() as $tech)
                        <span class="text-xs px-2.5 py-1 rounded-full bg-slate-100 dark:bg-white/5 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-white/10">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif

            @if ($project->description)
                <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 whitespace-pre-line">{{ $project->description }}</div>
            @endif

            @if ($project->featureList())
                <div class="mt-10">
                    <p class="text-sm font-medium bg-gradient-to-r from-pink-500 to-fuchsia-400 bg-clip-text text-transparent mb-3">Key Features</p>
                    <ul class="space-y-2.5">
                        @foreach ($project->featureList() as $feature)
                            <li class="flex items-start gap-2.5 text-slate-600 dark:text-slate-400">
                                <svg class="w-5 h-5 mt-0.5 text-fuchsia-600 dark:text-fuchsia-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </article>

</x-site-layout>
