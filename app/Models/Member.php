<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use TomatoPHP\FilamentMediaManager\Traits\InteractsWithMediaManager;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use InteractsWithMediaManager;

    const TYPE_EXECUTIVE_COMMITTEE = 'executive-committee';
    const TYPE_ADVISORY_BOARD = 'advisory-board';

    const TYPES = [
        self::TYPE_EXECUTIVE_COMMITTEE => 'Executive comitee',
        self::TYPE_ADVISORY_BOARD => 'Advisory board',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'email',
        'last_name',
        'title',
        'role',
        'organisation',
        'types',
        'interests',
        'bio',
        'last_active_at',
        'avatar'
    ];

    protected $appends = ['avatar_url'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'types' => 'array',
            'interests' => 'array',
            'last_active_at' => 'datetime',
        ];
    }

    #[Scope]
    protected function executiveCommittee(Builder $query)
    {
        $query->whereJsonContains('types', self::TYPE_EXECUTIVE_COMMITTEE);
    }

    #[Scope]
    protected function advisoryBoard(Builder $query)
    {
        $query->whereJsonContains('types', self::TYPE_ADVISORY_BOARD);
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMediaManagerUrl('member-avatars')
        );
    }
}
