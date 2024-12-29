<?php

use App\Models\Review;
use App\Models\ReviewMultimedia;
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
        Schema::create('review_multimedia', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Review::class)->constrained();
            $table->string('file');
            $table->string('file_type', 20)->default(ReviewMultimedia::TYPE_IMAGE);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_multimedia');
    }
};
