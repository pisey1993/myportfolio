@php $experience = $experience ?? null; @endphp

<div>
    <label for="title" class="block text-[13px] font-semibold text-[#0f172a]">Job Title</label>
    <input type="text" name="title" id="title" value="{{ old('title', $experience?->title) }}" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('title')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="company" class="block text-[13px] font-semibold text-[#0f172a]">Company</label>
    <input type="text" name="company" id="company" value="{{ old('company', $experience?->company) }}" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('company')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <label for="start_label" class="block text-[13px] font-semibold text-[#0f172a]">Start</label>
        <input type="text" name="start_label" id="start_label" value="{{ old('start_label', $experience?->start_label) }}" required placeholder="e.g. January 2025 or 2018"
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
        @error('start_label')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="end_label" class="block text-[13px] font-semibold text-[#0f172a]">End</label>
        <input type="text" name="end_label" id="end_label" value="{{ old('end_label', $experience?->end_label) }}" placeholder="Leave blank for Present"
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
        <p class="mt-1 text-[12px] text-[#94a3b8]">Blank shows as "Present".</p>
        @error('end_label')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
    </div>
</div>

<div>
    <label for="highlights" class="block text-[13px] font-semibold text-[#0f172a]">Highlights</label>
    <textarea name="highlights" id="highlights" rows="6"
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">{{ old('highlights', $experience?->highlights) }}</textarea>
    <p class="mt-1 text-[12px] text-[#94a3b8]">One bullet point per line.</p>
    @error('highlights')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="sort_order" class="block text-[13px] font-semibold text-[#0f172a]">Sort Order</label>
    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $experience?->sort_order ?? 0) }}"
        class="mt-1 block w-full max-w-[160px] rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    <p class="mt-1 text-[12px] text-[#94a3b8]">Lower numbers show first (1 = most recent).</p>
</div>
