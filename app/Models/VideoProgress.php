<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoProgress extends Model
{
    protected $table = 'video_progress';
    protected $fillable = ['user_id','lesson_id','source','last_second','watched_seconds'];
}


