<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Answeroption extends Model
{
	protected $fillable = ['text', 'question_id', 'iscorrect'];
   
    public function questionId(){
    return $this->belongsTo(Question::class);
}
}
