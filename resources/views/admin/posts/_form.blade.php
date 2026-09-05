@php $post = $post ?? null; @endphp

<div>
    <label for="title" class="block text-[13px] font-semibold text-[#0f172a]">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title', $post?->title) }}" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('title')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="excerpt" class="block text-[13px] font-semibold text-[#0f172a]">Excerpt</label>
    <input type="text" name="excerpt" id="excerpt" value="{{ old('excerpt', $post?->excerpt) }}"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    <p class="mt-1 text-[12px] text-[#94a3b8]">Short summary shown in listings.</p>
    @error('excerpt')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="body" class="block text-[13px] font-semibold text-[#0f172a]">Body</label>
    <textarea name="body" id="body" rows="12" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">{{ old('body', $post?->body) }}</textarea>
    @error('body')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="cover_image" class="block text-[13px] font-semibold text-[#0f172a]">Cover Image URL</label>
    <input type="text" name="cover_image" id="cover_image" value="{{ old('cover_image', $post?->cover_image) }}" placeholder="https://"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('cover_image')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6 items-end">
    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $post?->is_published) ? 'checked' : '' }}
            class="rounded-[2px] border-[#94a3b8] text-[#4f46e5] focus:ring-[#4f46e5] focus:ring-offset-0">
        <label for="is_published" class="text-[13px] font-semibold text-[#0f172a]">Published</label>
    </div>
    <div>
        <label for="published_at" class="block text-[13px] font-semibold text-[#0f172a]">Published At</label>
        <input type="datetime-local" name="published_at" id="published_at"
            value="{{ old('published_at', $post?->published_at?->format('Y-m-d\TH:i')) }}"
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
        <p class="mt-1 text-[12px] text-[#94a3b8]">Leave blank to publish immediately.</p>
    </div>
</div>
