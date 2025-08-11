<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_progress', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained();
            $t->foreignId('lesson_id')->constrained();
            $t->enum('source', ['vimeo','cloudflare','youtube']);
            $t->unsignedInteger('last_second')->default(0);
            $t->unsignedInteger('watched_seconds')->default(0);
            $t->timestamps();
            $t->unique(['user_id','lesson_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_progress');
    }
};
