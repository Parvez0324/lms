<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('pass_percentage')->default(70);
            $table->integer('time_limit_minutes')->default(15);
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};
