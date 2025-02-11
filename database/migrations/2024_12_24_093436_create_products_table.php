<?php

use App\Enums\ProductType;
use App\Models\Brand;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Brand::class)->constrained();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->unsignedInteger('views')->default(0);
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail');
            $table->tinyInteger('type')->default(ProductType::SINGLE);
            $table->string('sku')->unique()->nullable();
            $table->decimal('price', 11, 2)->nullable();
            $table->decimal('sale_price', 11, 2)->nullable();
            $table->timestamp('sale_price_start_at')->nullable();
            $table->timestamp('sale_price_end_at')->nullable();
            $table->boolean('is_sale');
            $table->boolean('is_featured');
            $table->boolean('is_trending');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
