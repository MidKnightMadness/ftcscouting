<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $guarded = [];

    public function responses(){
        return $this->hasMany('App\Response', 'question_id', 'question_id');
    }
}
