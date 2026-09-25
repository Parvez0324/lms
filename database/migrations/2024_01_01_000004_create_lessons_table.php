<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            $table->string('title');
            $table->string('slug');
            $table->string('content_type')->default('video'); // video, pdf, article
            $table->string('video_url')->nullable(); // youtube/vimeo/mp4 URL
            $table->string('video_path')->nullable(); // uploaded video path
            $table->string('pdf_path')->nullable(); // uploaded pdf path
            $table->longText('article_content')->nullable();
            $table->integer('duration_minutes')->default(10);
            $table->integer('order')->default(1);
            $table->boolean('is_preview')->default(false); // Can be viewed before enrolling
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
