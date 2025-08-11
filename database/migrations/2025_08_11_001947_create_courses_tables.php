<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $t) {
            $t->id();
            $t->string('slug')->unique();
            $t->string('level')->nullable();
            $t->boolean('published')->default(false);
            $t->timestamps();
        });
        Schema::create('courses_i18n', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained();
            $t->string('locale', 2);
            $t->string('title');
            $t->text('description')->nullable();
            $t->unique(['course_id', 'locale']);
        });
        Schema::create('chapters', function (Blueprint $t) {
            $t->id();
            $t->foreignId('course_id')->constrained();
            $t->string('title');
            $t->unsignedInteger('position');
            $t->timestamps();
        });
        Schema::create('lessons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('chapter_id')->constrained();
            $t->enum('type', ['video','audio','pdf','text','iframe','quiz']);
            $t->json('config')->nullable();
            $t->unsignedInteger('position');
            $t->boolean('locked')->default(false);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('courses_i18n');
        Schema::dropIfExists('courses');
    }
};
