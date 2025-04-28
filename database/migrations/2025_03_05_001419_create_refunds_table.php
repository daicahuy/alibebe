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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id(); //
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('user_handle')->unsigned()->nullable();
            $table->decimal('total_amount', 12, 2);
            $table->string('bank_account', 255)->nullable();
            $table->string('user_bank_name', 255)->nullable();
            $table->string('phone_number', 20);
            $table->string('bank_name', 100)->nullable();
            $table->text('reason');
            $table->text('fail_reason')->nullable();
            $table->text('img_fail_or_completed')->nullable();
            $table->text('reason_image');
            $table->text('admin_reason')->nullable();
            $table->boolean('is_send_money')->default(null)->nullable();

            $table->enum('status', [
                'pending',
                'receiving',
                'completed',
                'rejected',
                'failed',
                'cancel'
            ])->default('pending');
            $table->enum('bank_account_status', [
                'unverified',
                'sent',
                'verified'
            ])->default('unverified');
            $table->timestamps();


            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_handle')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
