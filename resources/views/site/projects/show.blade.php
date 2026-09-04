<x-site-layout :title="$project->title . ' — ' . \App\Models\SiteSetting::current()->headline" :description="$project->summary">

    <article>
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[50rem] h-[20rem] bg-gradient-to-tr from-pink-600/20 via-fuchsia-600/10 to-orange-500/10 blur-3xl rounded-full"></div>
            </div>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 sm:pt-20 pb-8">
                <a href="{{ route('projects.index') }}" class="text-sm text-gray-500 hover:text-white">&larr; All projects</a>

                <h1 class="mt-4 text-3xl sm:text-4xl font-extrabold text-white">{{ $project->title }}</h1>
                <p class="mt-3 text-lg text-gray-400">{{ $project->summary }}</p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($project->project_url)
                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="inline-flex items-center px-5 py-2.5 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-500 text-white text-sm font-semibold hover:from-pink-500 hover:to-fuchsia-400 transition">
                            Live site &#8599;
                        </a>
                    @endif
                    @if ($project->repo_url)
                        <a href="{{ $project->repo_url }}" target="_blank" rel="noopener" class="inline-flex items-center px-5 py-2.5 rounded-full border border-white/20 text-white text-sm font-medium hover:bg-white/5 transition">
                            Source code &#8599;
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="aspect-video rounded-2xl overflow-hidden border border-white/10">
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
                        <span class="text-xs px-2.5 py-1 rounded-full bg-white/5 text-gray-400 border border-white/10">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif

            @if ($project->description)
                <div class="prose prose-invert max-w-none text-gray-300 whitespace-pre-line">{{ $project->description }}</div>
            @endif
        </div>
    </article>

</x-site-layout>
