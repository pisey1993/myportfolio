<x-site-layout :title="'Projects — ' . config('app.name')">

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-16">
        <h1 class="text-3xl font-bold text-gray-900">Projects</h1>
        <p class="mt-3 text-gray-600">A selection of things I've built.</p>

        @if ($projects->isEmpty())
            <p class="mt-12 text-gray-500">No projects yet — check back soon.</p>
        @else
            <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <a href="{{ route('projects.show', $project) }}" class="group block rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition">
                        <div class="aspect-video bg-gray-100 flex items-center justify-center overflow-hidden">
                            @if ($project->image)
                                <img src="{{ $project->image }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-300 text-3xl font-semibold">{{ substr($project->title, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition">{{ $project->title }}</h3>
                            <p class="mt-1.5 text-sm text-gray-600 line-clamp-2">{{ $project->summary }}</p>
                            @if ($project->tech_stack)
                                <div class="mt-3 flex flex-wrap gap-1.5">
                                    @foreach ($project->techStackList() as $tech)
                                        <span class="text-xs px-2 py-0.5 rounded bg-gray-100 text-gray-600">{{ $tech }}</span>
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
