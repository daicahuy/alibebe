<?php

use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('history_order_statuses', function (Blueprint $table) {
            $table->foreignIdFor(Order::class)->constrained();
            $table->foreignIdFor(OrderStatus::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_order_statuses');
    }
};
