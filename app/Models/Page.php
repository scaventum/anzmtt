<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TomatoPHP\FilamentMediaManager\Traits\InteractsWithMediaManager;

class Page extends Model
{

    use InteractsWithMediaManager;

    const TYPE_GENERAL = 'general';
    const TYPE_NEWS = 'news';
    const TYPE_CONFERENCES = 'conferences';
    const TYPE_CALL_FOR_PAPERS = 'call-for-papers';

    const TYPES = [
        self::TYPE_GENERAL => 'General',
        self::TYPE_NEWS => 'News',
        self::TYPE_CONFERENCES => 'Conferences',
        self::TYPE_CALL_FOR_PAPERS => 'Call for papers',
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

    public function conference()
    {
        return $this->hasOne(Conference::class);
    }

    public function callForPapers()
    {
        return $this->hasOne(CallForPapers::class);
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

    protected function shortTitle(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->short_title ?? $this->title,
        );
    }

    protected function hero(): Attribute
    {
        return Attribute::make(
            get: function ($value): ?array {
                $hero = json_decode($value, true);
                return array_merge($hero, [
                    'backgroundImage' => (object) [
                        'src' => $this->getMediaManagerUrl('page-hero-images')
                    ]
                ]);
            }
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
        $query->where('type', static::TYPE_NEWS);
    }

    #[Scope]
    protected function conferences(Builder $query): void
    {
        $query->where('type', static::TYPE_CONFERENCES);
    }

    #[Scope]
    protected function callForPapersPages(Builder $query): void
    {
        $query->where('type', static::TYPE_CALL_FOR_PAPERS);
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
