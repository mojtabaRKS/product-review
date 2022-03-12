<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public const PENDING_STATUS = 'pending';
    public const APPROVED_STATUS = 'approved';
    public const REJECT_STATUS = 'reject';

    public const ALL_STATUSES = [
        self::PENDING_STATUS,
        self::APPROVED_STATUS,
        self::REJECT_STATUS,
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'description',
        'status',
    ];
}
