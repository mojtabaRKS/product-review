<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    public const APPROVED_STATUS = 'approved';
    public const PENDING_STATUS = 'pending';
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
