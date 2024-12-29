<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('google_id')->nullable();
            $table->string('phone_number', 20)->unique();
            $table->string('email', 100)->unique()->nullable();
            $table->string('password');
            $table->string('fullname', 100)->nullable();
            $table->string('avatar')->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedBigInteger('loyalty_points')->default(0);
            $table->string('role', 30)->default(User::ROLE_CUSTOMER);
            $table->string('status', 20)->default(User::STATUS_ACTIVE);
            $table->rememberToken();
            $table->timestamp('verified_at')->nullable();
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
