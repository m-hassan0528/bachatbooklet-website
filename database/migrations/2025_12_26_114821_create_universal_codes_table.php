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
        Schema::create('universal_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 32)->unique();
            $table->integer('max_redemptions')->default(3);
            $table->integer('redemption_count')->default(0);
            $table->enum('status', ['active', 'inactive', 'exhausted'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('code');
            $table->index('status');
            $table->index(['status', 'redemption_count']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universal_codes');
    }
};
