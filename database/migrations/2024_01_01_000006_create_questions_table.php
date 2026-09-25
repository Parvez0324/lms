<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->text('question_text');
            $table->json('options'); // json array of choices, e.g. ["A", "B", "C", "D"]
            $table->string('correct_answer'); // e.g. "0" or "A" or option text
            $table->text('explanation')->nullable();
            $table->integer('points')->default(1);
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
