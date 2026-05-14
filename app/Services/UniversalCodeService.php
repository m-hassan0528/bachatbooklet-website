<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\UniversalCode;
use App\Models\UniversalCodeRedemption;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UniversalCodeService
{
    /**
     * Generate a unique 5-character alphanumeric code.
     */
    public function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(5));
        } while (UniversalCode::where('code', $code)->exists());

        return $code;
    }

    /**
     * Create a single universal code.
     */
    public function createCode(?string $notes = null): UniversalCode
    {
        return UniversalCode::create([
            'code' => $this->generateUniqueCode(),
            'max_redemptions' => 3,
            'redemption_count' => 0,
            'status' => 'active',
            'notes' => $notes,
        ]);
    }

    /**
     * Generate multiple universal codes in bulk.
     */
    public function bulkCreateCodes(int $count, ?string $notes = null): Collection
    {
        $codes = collect();

        for ($i = 0; $i < $count; $i++) {
            $codes->push($this->createCode($notes));
        }

        return $codes;
    }

    /**
     * Validate if a code can be redeemed for a specific brand.
     */
    public function validateCode(string $code, ?int $brandId = null): array
    {
        $universalCode = UniversalCode::where('code', $code)->first();

        if (!$universalCode) {
            return [
                'valid' => false,
                'message' => 'Invalid code.',
                'code' => null,
            ];
        }

        if ($universalCode->status !== 'active') {
            return [
                'valid' => false,
                'message' => 'This code is no longer active.',
                'code' => $universalCode,
            ];
        }

        // Check per-brand redemption limit if brand is specified
        if ($brandId) {
            if (!$universalCode->canBeRedeemedForBrand($brandId)) {
                $used = $universalCode->getRedemptionsForBrand($brandId);
                return [
                    'valid' => false,
                    'message' => "This code has already been redeemed {$used} times for this brand (maximum 3 per brand).",
                    'code' => $universalCode,
                ];
            }

            $remaining = $universalCode->getRemainingRedemptionsForBrand($brandId);
            return [
                'valid' => true,
                'message' => "Code valid for this brand. {$remaining} redemptions remaining for this brand.",
                'code' => $universalCode,
            ];
        }

        // General validation (no specific brand)
        return [
            'valid' => true,
            'message' => "Code is active and can be redeemed 3 times per brand.",
            'code' => $universalCode,
        ];
    }

    /**
     * Process code redemption for a specific brand.
     */
    public function redeemCode(
        UniversalCode $code,
        Brand $brand,
        ?array $customerInfo = null,
        ?string $redeemedBy = null,
        ?string $notes = null
    ): UniversalCodeRedemption {
        // Check if code can be redeemed for this specific brand
        if (!$code->canBeRedeemedForBrand($brand->id)) {
            $used = $code->getRedemptionsForBrand($brand->id);
            throw new \Exception("This code has already been redeemed {$used} times for {$brand->name} (maximum 3 per brand).");
        }

        DB::beginTransaction();

        try {
            // Create redemption record
            $redemption = UniversalCodeRedemption::create([
                'universal_code_id' => $code->id,
                'brand_id' => $brand->id,
                'customer_info' => $customerInfo,
                'redeemed_by' => $redeemedBy,
                'notes' => $notes,
            ]);

            // Increment global redemption count (for statistics/tracking)
            $code->increment('redemption_count');

            DB::commit();

            return $redemption;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get statistics for dashboard.
     */
    public function getCodeStats(): array
    {
        return [
            'total' => UniversalCode::count(),
            'active' => UniversalCode::active()->count(),
            'inactive' => UniversalCode::where('status', 'inactive')->count(),
            'total_redemptions' => UniversalCodeRedemption::count(),
        ];
    }
}
