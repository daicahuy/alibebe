<?php

use App\Models\Brand;
use App\Models\Product;
use App\Models\Promotion;
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
            $table->foreignIdFor(Promotion::class)->nullable()->constrained();
            $table->string('name');
            $table->string('slug');
            $table->string('outstanding_features')->nullable();
            $table->string('video')->nullable();
            $table->text('content')->nullable();
            $table->string('thumbnail');
            $table->string('sku')->nullable();
            $table->decimal('price', 11, 2)->nullable();
            $table->decimal('sale_price', 11, 2)->nullable();
            $table->integer('stock')->nullable();
            $table->string('type', 50)->default(Product::TYPE_SINGLE);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
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
