<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
	public function courses(){
    return $this->belongsToMany(Course::Class, 'courses_tags');
}
}
