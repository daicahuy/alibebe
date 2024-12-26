<?php

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderConfirmation;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promotion;
use App\Models\Review;
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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->nullable()->constrained();
            $table->foreignIdFor(Attribute::class)->nullable()->constrained();
            $table->foreignIdFor(AttributeValue::class)->nullable()->constrained();
            $table->foreignIdFor(Product::class)->nullable()->constrained();
            $table->foreignIdFor(ProductVariant::class)->nullable()->constrained();
            $table->foreignIdFor(Payment::class)->nullable()->constrained();
            $table->foreignIdFor(Order::class)->nullable()->constrained();
            $table->foreignIdFor(OrderConfirmation::class)->nullable()->constrained();
            $table->foreignIdFor(Review::class)->nullable()->constrained();
            $table->foreignIdFor(Promotion::class)->nullable()->constrained();
            $table->foreignIdFor(Coupon::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->text('action')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
