@php $project = $project ?? null; @endphp

<div>
    <label for="title" class="block text-[13px] font-semibold text-[#0f172a]">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title', $project?->title) }}" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('title')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="summary" class="block text-[13px] font-semibold text-[#0f172a]">Summary</label>
    <input type="text" name="summary" id="summary" value="{{ old('summary', $project?->summary) }}" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    <p class="mt-1 text-[12px] text-[#94a3b8]">Shown in cards and listings.</p>
    @error('summary')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="description" class="block text-[13px] font-semibold text-[#0f172a]">Description</label>
    <textarea name="description" id="description" rows="6"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">{{ old('description', $project?->description) }}</textarea>
    @error('description')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="features" class="block text-[13px] font-semibold text-[#0f172a]">Key Features</label>
    <textarea name="features" id="features" rows="8"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">{{ old('features', $project?->features) }}</textarea>
    <p class="mt-1 text-[12px] text-[#94a3b8]">One feature per line. Shown as a bullet list on the project page.</p>
    @error('features')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <label for="project_url" class="block text-[13px] font-semibold text-[#0f172a]">Live URL</label>
        <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $project?->project_url) }}" placeholder="https://"
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
        @error('project_url')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="repo_url" class="block text-[13px] font-semibold text-[#0f172a]">Repository URL</label>
        <input type="url" name="repo_url" id="repo_url" value="{{ old('repo_url', $project?->repo_url) }}" placeholder="https://"
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
        @error('repo_url')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
    </div>
</div>

<div>
    <label for="image" class="block text-[13px] font-semibold text-[#0f172a]">Image URL</label>
    <input type="text" name="image" id="image" value="{{ old('image', $project?->image) }}" placeholder="https://"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('image')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="tech_stack" class="block text-[13px] font-semibold text-[#0f172a]">Tech Stack</label>
    <input type="text" name="tech_stack" id="tech_stack" value="{{ old('tech_stack', $project?->tech_stack) }}" placeholder="Laravel, MySQL, Tailwind CSS"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    <p class="mt-1 text-[12px] text-[#94a3b8]">Comma-separated.</p>
    @error('tech_stack')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6 items-end">
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $project?->is_featured) ? 'checked' : '' }}
            class="rounded-[2px] border-[#94a3b8] text-[#4f46e5] focus:ring-[#4f46e5] focus:ring-offset-0">
        <label for="is_featured" class="text-[13px] font-semibold text-[#0f172a]">Featured on homepage</label>
    </div>
    <div>
        <label for="sort_order" class="block text-[13px] font-semibold text-[#0f172a]">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $project?->sort_order ?? 0) }}"
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    </div>
</div>
