<?php

use App\Models\Coupon;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('quantity');
            $table->decimal('min_order', 10, 2)->nullable();
            $table->decimal('max_coupon_value', 10, 2)->nullable();
            $table->unsignedInteger('percent_decrease')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->string('type', 20)->default(Coupon::TYPE_PERCENT);
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
