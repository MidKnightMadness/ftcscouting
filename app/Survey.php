<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    
    protected $guarded = [];


    public function questions(){
        return $this->hasMany('App\Question', 'survey_id', 'id')->orderBy('order');
    }

    public function responses(){
        return $this->hasMany('App\Response', 'survey', 'id')->orderBy('team')->orderBy('initial', 'DESC');
    }
}
