<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'video_url',
        'type',
        'is_published',
        'published_at',
    ];

    public const TYPE_ARTICLE = 'article';

    public const TYPE_VIDEO = 'video';

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function scopeVideos($query)
    {
        return $query->where('type', self::TYPE_VIDEO);
    }

    public function scopeArticles($query)
    {
        return $query->where('type', self::TYPE_ARTICLE);
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([\w-]+)/', $this->video_url, $matches)) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }

        if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches)) {
            return "https://player.vimeo.com/video/{$matches[1]}";
        }

        return $this->video_url;
    }
}
