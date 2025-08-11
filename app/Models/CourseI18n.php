<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseI18n extends Model
{
    public $timestamps = false;
    protected $table = 'courses_i18n';
    protected $fillable = ['course_id','locale','title','description'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}


