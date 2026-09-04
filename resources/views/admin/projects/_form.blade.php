@php $project = $project ?? null; @endphp

<div>
    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title', $project?->title) }}" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label for="summary" class="block text-sm font-medium text-gray-700">Summary</label>
    <input type="text" name="summary" id="summary" value="{{ old('summary', $project?->summary) }}" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    <p class="mt-1 text-xs text-gray-400">Shown in cards and listings.</p>
    @error('summary')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="description" rows="6"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $project?->description) }}</textarea>
    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <label for="project_url" class="block text-sm font-medium text-gray-700">Live URL</label>
        <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $project?->project_url) }}" placeholder="https://"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('project_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="repo_url" class="block text-sm font-medium text-gray-700">Repository URL</label>
        <input type="url" name="repo_url" id="repo_url" value="{{ old('repo_url', $project?->repo_url) }}" placeholder="https://"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('repo_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div>
    <label for="image" class="block text-sm font-medium text-gray-700">Image URL</label>
    <input type="text" name="image" id="image" value="{{ old('image', $project?->image) }}" placeholder="https://"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label for="tech_stack" class="block text-sm font-medium text-gray-700">Tech Stack</label>
    <input type="text" name="tech_stack" id="tech_stack" value="{{ old('tech_stack', $project?->tech_stack) }}" placeholder="Laravel, MySQL, Tailwind CSS"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    <p class="mt-1 text-xs text-gray-400">Comma-separated.</p>
    @error('tech_stack')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6 items-end">
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $project?->is_featured) ? 'checked' : '' }}
            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <label for="is_featured" class="text-sm font-medium text-gray-700">Featured on homepage</label>
    </div>
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $project?->sort_order ?? 0) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>
</div>
