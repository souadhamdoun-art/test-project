<?php

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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('paddle_product_id');
            $table->string('slug')->unique();
            $table->string('image_name')->nullable();
            $table->string('tagline')->nullable();
            $table->json('learnings')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('difficulty')->nullable();
            $table->boolean('is_published')->default(false);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
