<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
  public function answeroptions() {
    	return $this->hasMany('App\Answeroption');
    }  

    public function quizId(){
    return $this->belongsTo(Quiz::class);
}
}
