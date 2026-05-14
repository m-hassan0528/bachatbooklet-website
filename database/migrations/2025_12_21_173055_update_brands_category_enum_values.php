<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Change column to VARCHAR to allow any value temporarily
        DB::statement("ALTER TABLE brands MODIFY COLUMN category VARCHAR(50) NULL");

        // Step 2: Update existing data to map old values to new ones
        DB::statement("UPDATE brands SET category = 'health_wellness' WHERE category = 'health_fitness'");
        DB::statement("UPDATE brands SET category = 'food_drink' WHERE category = 'food_drinks'");
        DB::statement("UPDATE brands SET category = 'travel_tourism' WHERE category = 'travel'");
        DB::statement("UPDATE brands SET category = 'beauty_fitness' WHERE category = 'salon_spa'");
        DB::statement("UPDATE brands SET category = 'entertainment' WHERE category = 'leisure'");
        // 'services' stays the same

        // Step 3: Change column back to ENUM with new values
        DB::statement("ALTER TABLE brands MODIFY COLUMN category ENUM('food_drink', 'beauty_fitness', 'fashion_retail', 'entertainment', 'travel_tourism', 'services', 'health_wellness', 'home_lifestyle') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE brands MODIFY COLUMN category ENUM('health_fitness', 'food_drinks', 'travel', 'services', 'salon_spa', 'leisure') NULL");
    }
};
