<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    protected $fillable = [
        'title',
        'short_title',
        'slug',
        'blocks', // Only blocks field
        'published',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'blocks' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function previewUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => route('page.preview', $this->slug),
        );
    }
    protected function url(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->published ? route('page.show', $this->slug) : null,
        );
    }
}
