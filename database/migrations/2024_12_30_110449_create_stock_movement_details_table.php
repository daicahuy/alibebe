<?php

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
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
        Schema::create('stock_movement_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(StockMovement::class)->constrained();
            $table->foreignIdFor(Product::class)->nullable()->constrained();
            $table->foreignIdFor(ProductVariant::class)->nullable()->constrained();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movement_details');
    }
};
