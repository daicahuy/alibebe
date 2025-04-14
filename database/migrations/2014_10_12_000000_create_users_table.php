<?php

use App\Enums\UserRoleType;
use App\Enums\UserStatusType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('google_id', 255)->nullable();
            $table->string('facebook_id', 255)->nullable();
            $table->string('phone_number', 20)->unique()->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('password');
            $table->string('fullname', 100)->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('loyalty_points')->default(0);
            $table->tinyInteger('role')->default(UserRoleType::CUSTOMER);
            $table->tinyInteger('status')->default(UserStatusType::ACTIVE);
            $table->string('code_verified_email', 255)->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('code_verified_at')->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('user_bank_name', 255)->nullable();
            $table->string('bank_account', 255)->nullable();
            $table->string('reason_lock', 255)->nullable();
            $table->timestamp('order_blocked_until')->nullable();
            $table->integer('time_block_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
