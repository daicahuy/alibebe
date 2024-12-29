<?php

use App\Models\Product;
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained();
            $table->string('sku')->unique()->nullable();
            $table->decimal('price', 11, 2);
            $table->decimal('sale_price', 11, 2);
            $table->timestamp('sale_price_start_at')->nullable();
            $table->timestamp('sale_price_end_at')->nullable();
            $table->string('thumbnail');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
