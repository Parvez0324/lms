<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('points')->default(100);
            $table->date('due_date')->nullable();
            $table->string('attachment_path')->nullable();
            $table->enum('status', ['active', 'draft'])->default('active');
            $table->timestamps();
        });

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('submission_text')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('score')->nullable();
            $table->string('grade')->nullable(); // e.g. "A+", "Star ⭐⭐⭐", "100/100"
            $table->text('feedback')->nullable();
            $table->enum('status', ['submitted', 'graded', 'resubmission_requested'])->default('submitted');
            $table->foreignId('graded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
    }
};
