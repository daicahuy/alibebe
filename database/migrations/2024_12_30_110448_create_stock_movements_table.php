<?php

use App\Enums\StockMovementType;
use App\Models\Product;
use App\Models\ProductVariant;
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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->nullable()->constrained();
            $table->foreignIdFor(ProductVariant::class)->nullable()->constrained();
            $table->integer('quantity');
            $table->tinyInteger('type')->default(StockMovementType::IMPORT);
            $table->text('reason')->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
