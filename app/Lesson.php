<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Lesson extends Model
{
    public function courseId(){
    return $this->belongsTo(Course::class);
}

public function users()
    {
        return $this->belongsToMany(User::class, 'lessons_users');
    }
    
}
