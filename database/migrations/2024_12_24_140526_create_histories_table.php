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
            $table->string('subject_type');
            $table->unsignedBigInteger('subject_id');
            $table->string('action_type', 50);
            $table->json('old_value')->nullable();
            $table->json('new_value')->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
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
