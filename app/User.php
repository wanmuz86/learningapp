<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use TCG\Voyager\Traits\VoyagerUser;
use App\Course;
use App\Lesson;
use App\Badge;
use TCG\Voyager\Models\User as VoyUser;

class User extends VoyUser
{
  
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_users');
    }

     public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lessons_users');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'badge_issued')->withTimestamps();
    }
}
