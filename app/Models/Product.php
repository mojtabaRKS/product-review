<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public const MODES = [
        self::PUBLIC_MODE,
        self::ORDER_MODE,
        self::NONE_MODE
    ];

    public const PUBLIC_MODE = 'public';
    public const ORDER_MODE = 'order';
    public const NONE_MODE = 'none';

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_visible',
        'comment_mode',
        'vote_mode'
    ];

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return HasMany
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
