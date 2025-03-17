<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('refund_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('refund_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('variant_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('name_variant')->nullable();
            $table->unsignedSmallInteger('quantity')->nullable();
            $table->decimal('price', 11, 2)->nullable();
            $table->decimal('price_variant', 11, 2)->nullable();
            $table->unsignedSmallInteger('quantity_variant')->nullable();


            $table->timestamps();

            $table->foreign('refund_id')->references('id')->on('refunds')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_items');
    }
};
