<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversalCodeRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'universal_code_id',
        'brand_id',
        'customer_info',
        'redeemed_by',
        'redeemed_at',
        'notes',
    ];

    protected $casts = [
        'customer_info' => 'array',
        'redeemed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the universal code that owns this redemption.
     */
    public function universalCode()
    {
        return $this->belongsTo(UniversalCode::class);
    }

    /**
     * Get the brand for this redemption.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
