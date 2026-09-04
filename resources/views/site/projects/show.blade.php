<x-site-layout :title="$project->title . ' — ' . config('app.name')" :description="$project->summary">

    <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24">
        <a href="{{ route('projects.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; All projects</a>

        <h1 class="mt-4 text-3xl font-bold text-gray-900">{{ $project->title }}</h1>
        <p class="mt-3 text-lg text-gray-600">{{ $project->summary }}</p>

        <div class="mt-6 flex flex-wrap gap-3">
            @if ($project->project_url)
                <a href="{{ $project->project_url }}" target="_blank" rel="noopener" class="inline-flex items-center px-4 py-2 rounded-md bg-gray-900 text-white text-sm font-medium hover:bg-gray-700 transition">
                    Live site &#8599;
                </a>
            @endif
            @if ($project->repo_url)
                <a href="{{ $project->repo_url }}" target="_blank" rel="noopener" class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                    Source code &#8599;
                </a>
            @endif
        </div>

        @if ($project->image)
            <img src="{{ $project->image }}" alt="{{ $project->title }}" class="mt-10 rounded-lg border border-gray-200 w-full object-cover">
        @endif

        @if ($project->tech_stack)
            <div class="mt-8 flex flex-wrap gap-2">
                @foreach ($project->techStackList() as $tech)
                    <span class="text-xs px-2.5 py-1 rounded bg-gray-100 text-gray-600">{{ $tech }}</span>
                @endforeach
            </div>
        @endif

        @if ($project->description)
            <div class="mt-8 prose prose-gray max-w-none text-gray-700 whitespace-pre-line">{{ $project->description }}</div>
        @endif
    </article>

</x-site-layout>
