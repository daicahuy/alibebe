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
        Schema::create('order_order_status', function (Blueprint $table) {
            $table->foreignIdFor(Order::class)->constrained();
            $table->foreignIdFor(OrderStatus::class)->constrained();
            $table->primary(['order_id', 'order_status_id']);
            $table->foreignId('modified_by')->nullable()->constrained('users');
            $table->string('note')->nullable();
            $table->string('employee_evidence', 255)->nullable();
            $table->boolean('customer_confirmation')->nullable();
            $table->boolean('is_current')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_order_status');
    }
};
