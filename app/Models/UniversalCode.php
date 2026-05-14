<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UniversalCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'max_redemptions',
        'redemption_count',
        'status',
        'notes',
    ];

    protected $casts = [
        'max_redemptions' => 'integer',
        'redemption_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the redemptions for this universal code.
     */
    public function redemptions()
    {
        return $this->hasMany(UniversalCodeRedemption::class);
    }

    /**
     * Check if the code is active.
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if all redemptions have been used (legacy - for global view).
     */
    public function getIsExhaustedAttribute(): bool
    {
        return $this->redemption_count >= $this->max_redemptions;
    }

    /**
     * Get remaining redemptions (legacy - for global view).
     */
    public function getRemainingRedemptionsAttribute(): int
    {
        return max(0, $this->max_redemptions - $this->redemption_count);
    }

    /**
     * Get total redemptions across all brands.
     */
    public function getTotalRedemptionsAttribute(): int
    {
        return $this->redemptions()->count();
    }

    /**
     * Get redemption count for a specific brand.
     */
    public function getRedemptionsForBrand(int $brandId): int
    {
        return $this->redemptions()
            ->where('brand_id', $brandId)
            ->count();
    }

    /**
     * Get remaining redemptions for a specific brand.
     */
    public function getRemainingRedemptionsForBrand(int $brandId): int
    {
        $used = $this->getRedemptionsForBrand($brandId);
        return max(0, $this->max_redemptions - $used);
    }

    /**
     * Check if the code can be redeemed for a specific brand.
     */
    public function canBeRedeemedForBrand(int $brandId): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        $redemptionsForBrand = $this->getRedemptionsForBrand($brandId);
        return $redemptionsForBrand < $this->max_redemptions;
    }

    /**
     * Check if the code can be redeemed (general check - status only).
     */
    public function canBeRedeemed(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Scope for active codes.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for available codes (active and not exhausted).
     */
    public function scopeAvailable($query)
    {
        return $query->active()
                     ->whereColumn('redemption_count', '<', 'max_redemptions');
    }

    /**
     * Scope for exhausted codes.
     */
    public function scopeExhausted($query)
    {
        return $query->whereColumn('redemption_count', '>=', 'max_redemptions');
    }
}
