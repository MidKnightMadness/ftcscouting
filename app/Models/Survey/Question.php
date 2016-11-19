<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $guarded = [];


    public function pin(){
        return $this->hasOne('App\PIN', 'question', 'id');
    }
}
