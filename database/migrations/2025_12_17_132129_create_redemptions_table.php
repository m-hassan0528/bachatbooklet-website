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
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->foreignId('pin_id')->nullable()->constrained('redemption_pins')->onDelete('set null');
            $table->string('pin_code');
            $table->json('customer_info')->nullable();
            $table->string('redeemed_by')->nullable();
            $table->timestamp('redeemed_at')->useCurrent();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('voucher_id');
            $table->index('brand_id');
            $table->index('pin_id');
            $table->index('redeemed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redemptions');
    }
};
