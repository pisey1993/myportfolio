<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'description',
        'image',
        'tech_stack',
        'project_url',
        'repo_url',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function techStackList(): array
    {
        return array_filter(array_map('trim', explode(',', (string) $this->tech_stack)));
    }
}
