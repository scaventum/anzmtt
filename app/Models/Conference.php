<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    public function information(): Attribute
    {
        return Attribute::get(function ($value) {
            if (! $value) {
                return $value;
            }

            libxml_use_internal_errors(true);

            $dom = new \DOMDocument();
            $dom->loadHTML($value, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            foreach ($dom->getElementsByTagName('img') as $img) {
                $dataId = $img->getAttribute('data-id');

                if ($dataId) {
                    $img->setAttribute(
                        'src',
                        Storage::disk('s3')->url($dataId)
                    );
                }
            }

            return $dom->saveHTML();
        });
    }


    protected function downloadableUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMediaManagerUrl('conference-downloadables')
        );
    }
}
