<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    const TYPE_GENERAL = 'general';
    const TYPE_NEWS = 'news';
    const TYPE_CONFERENCES = 'conferences';
    const TYPES = [
        self::TYPE_GENERAL => 'General',
        self::TYPE_NEWS => 'News',
        self::TYPE_CONFERENCES => 'Conferences',
    ];

    protected $fillable = [
        'title',
        'type',
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
    protected function slug(Builder $query, string $slug): void
    {
        $slug = $slug === '/' ? null : $slug;
        $query->where('slug', $slug);
    }

    #[Scope]
    protected function general(Builder $query): void
    {
        $query->where('type', 'general');
    }

    #[Scope]
    protected function news(Builder $query): void
    {
        $query->where('type', 'news');
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('published', true);
    }

    #[Scope]
    protected function draft(Builder $query): void
    {
        $query->where('published', false);
    }
}
