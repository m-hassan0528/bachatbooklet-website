<?php

namespace Database\Seeders;

use App\Services\UniversalCodeService;
use Illuminate\Database\Seeder;

class UniversalCodeSeeder extends Seeder
{
    protected UniversalCodeService $universalCodeService;

    public function __construct(UniversalCodeService $universalCodeService)
    {
        $this->universalCodeService = $universalCodeService;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Generating 1000 universal codes...');

        $codes = $this->universalCodeService->bulkCreateCodes(
            1000,
            'Initial batch - Auto-generated on ' . now()->format('Y-m-d H:i:s')
        );

        $this->command->info("Successfully generated {$codes->count()} universal codes!");
    }
}
