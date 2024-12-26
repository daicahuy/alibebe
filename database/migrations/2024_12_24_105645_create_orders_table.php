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
            $table->foreignIdFor(Coupon::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Payment::class)->constrained();
            $table->string('fullname')->nullable();
            $table->text('address')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->decimal('total_amount', 11, 2);
            $table->string('status', 30)->default(Order::STATUS_PENDING);
            $table->string('note')->nullable();
            $table->boolean('is_paid')->default(false);
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
