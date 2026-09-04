<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-normal text-[#1d2327]">Settings</h1>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto space-y-6">

            @if (session('status'))
                <div class="bg-white border-l-4 border-[#00a32a] shadow-sm px-4 py-3 text-[13px] text-[#1d2327]">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6"
                x-data="{
                    preview: null,
                    removeAvatar: false,
                    posX: {{ old('avatar_position_x', $settings->avatar_position_x) }},
                    posY: {{ old('avatar_position_y', $settings->avatar_position_y) }},
                    dragging: false,
                    hasImage: {{ $settings->avatarUrl() ? 'true' : 'false' }},
                    setFromEvent(e) {
                        const rect = e.currentTarget.getBoundingClientRect();
                        const point = e.touches ? e.touches[0] : e;
                        const x = ((point.clientX - rect.left) / rect.width) * 100;
                        const y = ((point.clientY - rect.top) / rect.height) * 100;
                        this.posX = Math.round(Math.min(100, Math.max(0, x)));
                        this.posY = Math.round(Math.min(100, Math.max(0, y)));
                    }
                }">
                @csrf
                @method('PUT')
                <input type="hidden" name="avatar_position_x" x-model="posX">
                <input type="hidden" name="avatar_position_y" x-model="posY">

                <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] p-6">
                    <h3 class="font-medium text-gray-900 mb-1">Profile photo</h3>
                    <p class="text-sm text-gray-500 mb-4">Shown as the hero photo on your homepage, and as your avatar elsewhere on the site.</p>

                    <div class="flex flex-col sm:flex-row gap-6">
                        <div class="space-y-3 shrink-0">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-blue-50 border border-gray-100 flex items-center justify-center">
                                <template x-if="preview">
                                    <img :src="preview" class="w-full h-full object-cover" :style="`object-position: ${posX}% ${posY}%`">
                                </template>
                                <template x-if="!preview">
                                    <div class="w-full h-full flex items-center justify-center">
                                        @if ($settings->avatarUrl())
                                            <img src="{{ $settings->avatarUrl() }}" class="w-full h-full object-cover" :style="`object-position: ${posX}% ${posY}%`" x-show="!removeAvatar">
                                        @endif
                                        <span class="font-bold text-2xl text-blue-600" @if($settings->avatarUrl()) x-show="removeAvatar" @endif>
                                            {{ strtoupper(substr($settings->headline ?: 'P', 0, 1)) }}
                                        </span>
                                    </div>
                                </template>
                            </div>

                            <label class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50 cursor-pointer">
                                Choose Photo
                                <input type="file" name="avatar" accept="image/*" class="hidden"
                                    @change="
                                        removeAvatar = false;
                                        const file = $event.target.files[0];
                                        if (file) { preview = URL.createObjectURL(file); hasImage = true; } else { preview = null; }
                                    ">
                            </label>
                            @if ($settings->avatarUrl())
                                <label class="flex items-center gap-2 text-sm text-red-600">
                                    <input type="checkbox" name="remove_avatar" value="1" x-model="removeAvatar" @change="hasImage = !removeAvatar" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    Remove current photo
                                </label>
                            @endif
                            <p class="text-xs text-gray-400">PNG or JPG, up to 2MB.</p>
                        </div>

                        <div class="flex-1 min-w-0" x-show="hasImage" x-cloak>
                            <p class="text-sm font-medium text-gray-700 mb-2">Photo position</p>
                            <div
                                class="relative w-full aspect-[16/10] max-w-sm rounded-lg overflow-hidden bg-blue-900 cursor-crosshair select-none"
                                @mousedown="dragging = true; setFromEvent($event)"
                                @mousemove="if (dragging) setFromEvent($event)"
                                @mouseup="dragging = false"
                                @mouseleave="dragging = false"
                                @touchstart="dragging = true; setFromEvent($event)"
                                @touchmove.prevent="if (dragging) setFromEvent($event)"
                                @touchend="dragging = false"
                            >
                                <img :src="preview || '{{ $settings->avatarUrl() }}'" class="absolute inset-0 w-full h-full object-cover pointer-events-none" :style="`object-position: ${posX}% ${posY}%`">
                                <div class="absolute w-6 h-6 -mt-3 -ml-3 rounded-full border-2 border-white shadow-lg pointer-events-none ring-1 ring-black/20"
                                    :style="`left: ${posX}%; top: ${posY}%`"></div>
                            </div>
                            <p class="mt-2 text-xs text-gray-400">Click or drag on the preview to move the photo's focal point — this controls what stays visible when it's cropped on the homepage.</p>
                        </div>
                    </div>
                    @error('avatar')<p class="mt-3 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] p-6 space-y-5">
                    <h3 class="font-medium text-gray-900">Hero section</h3>

                    <div>
                        <label for="headline" class="block text-sm font-medium text-gray-700">Name / Headline</label>
                        <input type="text" name="headline" id="headline" value="{{ old('headline', $settings->headline) }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
                        @error('headline')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="tagline" class="block text-sm font-medium text-gray-700">Tagline</label>
                        <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $settings->tagline) }}" required placeholder="e.g. Software Developer"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
                        @error('tagline')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="hero_description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="hero_description" id="hero_description" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">{{ old('hero_description', $settings->hero_description) }}</textarea>
                        @error('hero_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="bg-white border border-[#c3c4c7] rounded-[4px] shadow-[0_1px_1px_rgba(0,0,0,.04)] p-6 space-y-5">
                    <h3 class="font-medium text-gray-900">Contact & social links</h3>
                    <p class="text-sm text-gray-500 -mt-3">Shown in the hero, footer, and contact page. Leave blank to hide.</p>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Contact email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $settings->email) }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
                        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid sm:grid-cols-3 gap-5">
                        <div>
                            <label for="github_url" class="block text-sm font-medium text-gray-700">GitHub URL</label>
                            <input type="url" name="github_url" id="github_url" value="{{ old('github_url', $settings->github_url) }}" placeholder="https://github.com/..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
                            @error('github_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" id="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}" placeholder="https://linkedin.com/in/..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
                            @error('linkedin_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="twitter_url" class="block text-sm font-medium text-gray-700">Twitter / X URL</label>
                            <input type="url" name="twitter_url" id="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}" placeholder="https://x.com/..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2271b1] focus:ring-[#2271b1] sm:text-sm">
                            @error('twitter_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 text-sm font-medium text-gray-700">Preview site</a>
                    <button type="submit" class="px-5 py-2.5 rounded-md bg-[#2271b1] text-white text-sm font-medium hover:bg-[#135e96]">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
