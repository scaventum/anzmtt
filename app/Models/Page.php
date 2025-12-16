<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_title',
        'hero',
        'blocks',
        'published',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
        'hero' => 'array',
        'blocks' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function previewUrl(): Attribute
    {
        $slug = $this->slug;
        $path = $slug ? "/{$slug}" : "";

        return Attribute::make(
            get: fn() => url("preview{$path}"),
        );
    }

    protected function url(): Attribute
    {
        $slug = $this->slug;
        $path = $slug ? "/{$slug}" : "";

        return Attribute::make(
            get: fn() => $this->published ? url($path) : null,
        );
    }

    #[Scope]
    protected function whereSlug(Builder $query, string $slug): void
    {
        $slug = $slug === '/' ? null : $slug;

        $query->where('slug', $slug);
    }
}
