<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CallForPapers extends Model
{

    protected $fillable = [
        'publication_name',
        'journal',
        'publication_date_from',
        'publication_date_to',
        'submission_deadline',
        'information',
        'information_link',
        'page_id',
    ];

    protected $casts = [
        'publication_date_from' => 'date',
        'publication_date_to' => 'date',
        'submission_deadline' => 'date',
    ];

    protected $appends = ['ongoing'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function ongoing(): Attribute
    {
        return Attribute::get(
            fn(): bool =>
            $this->publication_date_from !== null
                && $this->publication_date_to !== null
                && $this->publication_date_from->lte(now())
                && $this->publication_date_to->gte(now())
        );
    }
}
