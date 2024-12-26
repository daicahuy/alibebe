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
            $table->string('fullname', 100);
            $table->string('email', 100)->unique()->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('birthday')->nullable();
            $table->string('role', 30)->default(User::ROLE_CUSTOMER);
            $table->boolean('is_active');
            $table->decimal('expense', 12, 2)->nullable();
            $table->rememberToken();
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
