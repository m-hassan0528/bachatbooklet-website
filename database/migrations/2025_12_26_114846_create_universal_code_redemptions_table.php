<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('universal_code_redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('universal_code_id')
                  ->constrained('universal_codes')
                  ->onDelete('cascade');
            $table->foreignId('brand_id')
                  ->constrained('brands')
                  ->onDelete('cascade');
            $table->json('customer_info')->nullable();
            $table->string('redeemed_by')->nullable();
            $table->timestamp('redeemed_at')->useCurrent();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index('universal_code_id');
            $table->index('brand_id');
            $table->index('redeemed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universal_code_redemptions');
    }
};
