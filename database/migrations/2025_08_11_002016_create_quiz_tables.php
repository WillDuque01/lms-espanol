<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('lesson_id')->constrained();
            $t->timestamps();
        });
        Schema::create('questions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('quiz_id')->constrained();
            $t->string('type');
            $t->text('prompt');
            $t->json('meta')->nullable();
            $t->timestamps();
        });
        Schema::create('options', function (Blueprint $t) {
            $t->id();
            $t->foreignId('question_id')->constrained();
            $t->text('text');
            $t->boolean('is_correct')->default(false);
            $t->timestamps();
        });
        Schema::create('quiz_attempts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('quiz_id')->constrained();
            $t->foreignId('user_id')->constrained();
            $t->unsignedSmallInteger('score')->default(0);
            $t->unsignedSmallInteger('max_score')->default(0);
            $t->json('answers')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
    }
};
