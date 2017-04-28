<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
     public function users()
    {
        return $this->belongsToMany(\TCG\Voyager\Models\User::class, 'courses_users');
    }

    public function lessons() {
    	return $this->hasMany('App\Lesson');
    }
}
