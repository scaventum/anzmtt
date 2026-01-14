<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentMediaManager\Traits\InteractsWithMediaManager;

class Conference extends Model
{
    use InteractsWithMediaManager;

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

    protected function downloadableUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMediaManagerUrl('conference-downloadables')
        );
    }
}
