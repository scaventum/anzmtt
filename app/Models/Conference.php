<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Conference extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'full_name',
        'cost',
        'location',
        'date_from',
        'date_to',
        'time_from',
        'time_to',
        'information',
        'registration_link',
        'call_for_abstract_link',
        'downloadables',
        'page_id',
    ];

    protected $casts = [
        'date_from' => 'date',
    ];

    protected $appends = ['upcoming', 'downloadable_url'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function upcoming(): Attribute
    {
        return Attribute::get(
            fn(): bool => $this->date_from?->isFuture() ?? false
        );
    }

    public function downloadableUrl(): Attribute
    {
        return Attribute::get(
            fn() => $this->downloadables ? Storage::disk('s3')->temporaryUrl($this->downloadables, now()->addMinutes(10)) : null
        );
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('conferences')
            ->useDisk('s3');
    }
}
