<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('level')->default('all_levels'); // beginner, intermediate, advanced, all_levels
            $table->string('language')->default('English');
            $table->decimal('price', 10, 2)->default(0.00); // 0 = Free
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('preview_video_url')->nullable();
            $table->json('requirements')->nullable(); // array of bullet points
            $table->json('outcomes')->nullable(); // array of what students will learn
            $table->string('status')->default('published'); // draft, published, archived
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
