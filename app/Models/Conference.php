<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
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
        'downloadables',
        'page_id',
    ];

    protected $casts = [
        'date_from' => 'date',
    ];

    protected $appends = ['upcoming'];

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
}
