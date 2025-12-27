<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    const TYPE_EXECUTIVE_COMMITEE = 'executive-commitee';
    const TYPE_ADVISORY_BOARD = 'advisory-board';

    const TYPES = [
        self::TYPE_EXECUTIVE_COMMITEE => 'Executive comitee',
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
    ];

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
}
