<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Answeroption extends Model
{
   
    public function questionId(){
    return $this->belongsTo(Question::class);
}
}
