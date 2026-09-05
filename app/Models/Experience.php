<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'title',
        'company',
        'start_label',
        'end_label',
        'highlights',
        'sort_order',
    ];

    public function isCurrent(): bool
    {
        return empty($this->end_label);
    }

    public function highlightList(): array
    {
        return array_filter(array_map('trim', explode("\n", (string) $this->highlights)));
    }
}
