<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PIN extends Model {
    protected $table = "pin";

    protected $guarded = [];

    protected function questionObj(){
        return $this->belongsTo(Question::class, 'question');
    }
}
