@php $skill = $skill ?? null; @endphp

<div>
    <label for="name" class="block text-[13px] font-semibold text-[#0f172a]">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $skill?->name) }}" required
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('name')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div>
    <label for="category" class="block text-[13px] font-semibold text-[#0f172a]">Category</label>
    <input type="text" name="category" id="category" value="{{ old('category', $skill?->category ?? 'General') }}" required placeholder="Backend, Frontend, Tools..."
        class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    @error('category')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <label for="level" class="block text-[13px] font-semibold text-[#0f172a]">Level (0-100)</label>
        <input type="number" name="level" id="level" min="0" max="100" value="{{ old('level', $skill?->level ?? 80) }}" required
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
        @error('level')<p class="mt-1 text-[13px] text-[#dc2626]">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="sort_order" class="block text-[13px] font-semibold text-[#0f172a]">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $skill?->sort_order ?? 0) }}"
            class="mt-1 block w-full rounded-xl border-[#94a3b8] shadow-[inset_0_1px_2px_rgba(0,0,0,.07)] focus:border-[#4f46e5] focus:ring-1 focus:ring-[#4f46e5] text-[14px]">
    </div>
</div>
