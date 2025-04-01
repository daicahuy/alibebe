<?php

use App\Models\Coupon;
use App\Models\Order;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->tinyInteger('type')->unsigned();
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->foreignIdFor(Coupon::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Order::class)->nullable()->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
