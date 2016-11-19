<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResponseData extends Model
{
    protected $table = 'response_data';


    public function question(){
        return $this->hasOne('App\Question', 'id', 'question_id');
    }
}
