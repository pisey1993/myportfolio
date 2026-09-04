<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'headline',
        'tagline',
        'hero_description',
        'avatar_path',
        'avatar_position_x',
        'avatar_position_y',
        'email',
        'github_url',
        'linkedin_url',
        'twitter_url',
    ];

    private static ?self $cached = null;

    /**
     * The site only ever has one settings row. Fetch (or create with sane
     * defaults) and memoize it for the duration of the request.
     */
    public static function current(): self
    {
        return static::$cached ??= static::query()->firstOrCreate(['id' => 1], [
            'headline' => config('app.name', 'Portfolio'),
            'tagline' => 'Software Developer',
            'hero_description' => "A software developer building web applications with Laravel. I enjoy turning ideas into clean, working products — from internal business tools to personal projects.",
        ]);
    }

    public function avatarUrl(): ?string
    {
        // A relative path rather than Storage::url() (which bakes in APP_URL) so the
        // image still loads correctly no matter what host/port you're browsing from.
        return $this->avatar_path ? '/storage/'.ltrim($this->avatar_path, '/') : null;
    }

    public function avatarObjectPosition(): string
    {
        return "{$this->avatar_position_x}% {$this->avatar_position_y}%";
    }
}
