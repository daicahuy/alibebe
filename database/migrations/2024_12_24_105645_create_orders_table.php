<?php

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Payment::class)->constrained();
            $table->string('phone_number', 20);
            $table->string('email')->nullable();
            $table->string('fullname');
            $table->text('address');
            $table->decimal('total_amount', 12, 2);
            $table->boolean('is_paid')->default(false);
            $table->foreignIdFor(Coupon::class)->constrained();
            $table->string('coupon_code', 50)->nullable();
            $table->string('coupon_description')->nullable();
            $table->string('coupon_discount_type', 20)->nullable();
            $table->decimal('coupon_discount_value', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
