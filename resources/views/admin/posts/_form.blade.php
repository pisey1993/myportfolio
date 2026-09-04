@php $post = $post ?? null; @endphp

<div>
    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title', $post?->title) }}" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
    <input type="text" name="excerpt" id="excerpt" value="{{ old('excerpt', $post?->excerpt) }}"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    <p class="mt-1 text-xs text-gray-400">Short summary shown in listings.</p>
    @error('excerpt')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
    <textarea name="body" id="body" rows="12" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('body', $post?->body) }}</textarea>
    @error('body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label for="cover_image" class="block text-sm font-medium text-gray-700">Cover Image URL</label>
    <input type="text" name="cover_image" id="cover_image" value="{{ old('cover_image', $post?->cover_image) }}" placeholder="https://"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    @error('cover_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6 items-end">
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $post?->is_published) ? 'checked' : '' }}
            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <label for="is_published" class="text-sm font-medium text-gray-700">Published</label>
    </div>
    <div>
        <label for="published_at" class="block text-sm font-medium text-gray-700">Published At</label>
        <input type="datetime-local" name="published_at" id="published_at"
            value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <p class="mt-1 text-xs text-gray-400">Leave blank to publish immediately.</p>
    </div>
</div>
