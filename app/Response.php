<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'responses';
    
    protected $guarded = [];

    public function data(){
        return $this->hasMany('App\ResponseData', 'response_id', 'id')
            ->join('questions', 'response_data.question_id', '=', 'questions.id')->select('response_data.*')->orderBy('order', 'asc');
    }
}
