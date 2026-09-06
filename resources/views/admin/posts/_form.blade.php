@php $post = $post ?? null; @endphp

<div x-data="{
    fetching: false,
    error: null,
    thumbnail: @js($post?->cover_image),
    generatingNews: false,
    newsError: null,
    async fetchMeta() {
        const url = this.$refs.videoUrl.value.trim();
        if (!url) { this.error = null; return; }
        this.fetching = true;
        this.error = null;
        try {
            const res = await fetch(@js(route('admin.posts.youtube-meta')) + '?url=' + encodeURIComponent(url), {
                headers: { 'Accept': 'application/json' },
            });
            const data = await res.json();
            if (!res.ok) {
                this.error = data.message || 'Could not fetch video info.';
                return;
            }
            if (!this.$refs.title.value.trim()) this.$refs.title.value = data.title;
            if (!this.$refs.coverImage.value.trim()) {
                this.$refs.coverImage.value = data.thumbnail_url;
                this.thumbnail = data.thumbnail_url;
            }
            this.$refs.type.value = 'video';
        } catch (e) {
            this.error = 'Could not fetch video info.';
        } finally {
            this.fetching = false;
        }
    },
    async generateNews() {
        this.generatingNews = true;
        this.newsError = null;
        try {
            const res = await fetch(@js(route('admin.posts.generate-news')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                },
            });
            const data = await res.json();
            if (!res.ok) {
                this.newsError = data.message || 'Could not generate a post right now.';
                return;
            }
            this.$refs.title.value = data.title;
            this.$refs.excerpt.value = data.excerpt || '';
            this.$refs.body.value = data.body;
            this.$refs.type.value = 'article';
            if (data.image_url) {
                this.$refs.coverImage.value = data.image_url;
                this.thumbnail = data.image_url;
            }
        } catch (e) {
            this.newsError = 'Could not generate a post right now.';
        } finally {
            this.generatingNews = false;
        }
    },
}" class="contents space-y-6">

<div class="rounded-xl border border-dashed border-[#c7d2fe] bg-[#eef2ff] p-4">
    <button type="button" @click="generateNews()" :disabled="generatingNews"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#4f46e5] text-white text-[13px] font-semibold hover:bg-[#4338ca] disabled:opacity-60 disabled:cursor-not-allowed">
        <span x-show="!generatingNews">✨ Generate from AI / coding / tech news</span>
        <span x-show="generatingNews" x-cloak>Generating…</span>
    </button>
    <p class="mt-2 text-[12px] text-[#4338ca]">Uses Gemini to write a post about a notable AI, coding, or tech story and fills in the fields below, including a cover image.</p>
    <p x-show="newsError" x-cloak x-text="newsError" class="mt-2 text-[13px] text-[#dc2626]"></p>
</div>

<div>
    <label for="title" class="block text-[13px] font-semibold text-[#0f172a]">Title</label>
    <input type="text" name="title" id="title" x-ref="title" value="{{ old('title', $post?->title) }}" required maxlength="255"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('title')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="type" class="block text-[13px] font-semibold text-[#0f172a]">Post Type</label>
    <select name="type" id="type" x-ref="type"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
        <option value="article" {{ old('type', $post?->type ?? 'article') === 'article' ? 'selected' : '' }}>Blog</option>
        <option value="video" {{ old('type', $post?->type ?? 'article') === 'video' ? 'selected' : '' }}>Video Blog</option>
    </select>
    <p class="mt-1 text-[12px] text-[#94a3b8]">Controls whether this post shows on the Blog page or the Video Blog page.</p>
    @error('type')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="excerpt" class="block text-[13px] font-semibold text-[#0f172a]">Excerpt</label>
    <input type="text" name="excerpt" id="excerpt" x-ref="excerpt" value="{{ old('excerpt', $post?->excerpt) }}" maxlength="255"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    <p class="mt-1 text-[12px] text-[#94a3b8]">Short summary shown in listings. Max 255 characters.</p>
    @error('excerpt')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="body" class="block text-[13px] font-semibold text-[#0f172a]">Body</label>
    <textarea name="body" id="body" x-ref="body" rows="12" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">{{ old('body', $post?->body) }}</textarea>
    @error('body')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="video_url" class="block text-[13px] font-semibold text-[#0f172a]">Video URL</label>
    <input type="text" name="video_url" id="video_url" x-ref="videoUrl" @change="fetchMeta()" value="{{ old('video_url', $post?->video_url) }}" placeholder="https://youtube.com/watch?v=..." maxlength="2048"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    <p class="mt-1 text-[12px] text-[#94a3b8]">Paste a YouTube link — the title and thumbnail below fill in automatically. Set this to make the post appear in the Video Blog.</p>
    <p x-show="fetching" x-cloak class="mt-1 text-[12px] text-[#4f46e5]">Fetching video info…</p>
    <p x-show="error" x-cloak x-text="error" class="mt-1 text-[13px] text-[#dc2626]"></p>
    @error('video_url')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="cover_image" class="block text-[13px] font-semibold text-[#0f172a]">Cover Image URL</label>
    <input type="text" name="cover_image" id="cover_image" x-ref="coverImage" @change="thumbnail = $refs.coverImage.value.trim() || null" value="{{ old('cover_image', $post?->cover_image) }}" placeholder="https://" maxlength="2048"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    <p class="mt-1 text-[12px] text-[#94a3b8]">Auto-filled from the video thumbnail or generated news image — override if you want a different image.</p>
    <img x-show="thumbnail" x-cloak :src="thumbnail" alt="Cover image preview" class="mt-2 w-40 aspect-video object-cover rounded-lg border border-[#e2e8f0]">
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

</div>
