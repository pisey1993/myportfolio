@php $skill = $skill ?? null; @endphp

<div>
    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name', $skill?->name) }}" required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
    <input type="text" name="category" id="category" value="{{ old('category', $skill?->category ?? 'General') }}" required placeholder="Backend, Frontend, Tools..."
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
    @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="grid sm:grid-cols-2 gap-6">
    <div>
        <label for="level" class="block text-sm font-medium text-gray-700">Level (0-100)</label>
        <input type="number" name="level" id="level" min="0" max="100" value="{{ old('level', $skill?->level ?? 80) }}" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
        @error('level')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $skill?->sort_order ?? 0) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
    </div>
</div>
