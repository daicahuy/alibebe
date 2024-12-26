<?php

use App\Models\Order;
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
        Schema::create('order_confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->unique()->constrained();
            $table->text('employee_evidence')->nullable();
            $table->boolean('customer_confirmation')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_confirmations');
    }
};
