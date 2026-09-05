<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = SiteSetting::current();

        $validated = $request->validate([
            'headline' => ['required', 'string', 'max:255'],
            'tagline' => ['required', 'string', 'max:255'],
            'hero_description' => ['required', 'string', 'max:1000'],
            'email' => ['nullable', 'email', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'telegram_url' => ['nullable', 'url', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'avatar_position_x' => ['nullable', 'integer', 'min:0', 'max:100'],
            'avatar_position_y' => ['nullable', 'integer', 'min:0', 'max:100'],
            'remove_avatar' => ['sometimes', 'boolean'],
        ]);

        if ($request->boolean('remove_avatar') && $settings->avatar_path) {
            Storage::disk('public')->delete($settings->avatar_path);
            $validated['avatar_path'] = null;
        }

        if ($request->hasFile('avatar')) {
            if ($settings->avatar_path) {
                Storage::disk('public')->delete($settings->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        unset($validated['avatar'], $validated['remove_avatar']);

        $settings->update($validated);

        return redirect()->route('admin.settings.edit')->with('status', 'Settings updated.');
    }
}
