<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Badge extends Model
{
    public function users()
    {
        return $this->belongsToMany(\TCG\Voyager\Models\User::class, 'badge_issued');
    }

    public function courseId() {
    	 return $this->belongsTo(Course::class);
    }
}
