<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';
    
    protected $guarded = [];


    public function questions(){
        return $this->hasMany('App\Question')->orderBy('order');
    }

    public function responses(){
        return $this->hasMany('App\Response')->orderBy('team')->orderBy('initial', 'DESC');
    }

    public function owner(){
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function teams(){
        $group = $this->hasMany('App\Response')->orderBy('team')->get();
        $array = [];
        foreach($group as $item){
            if(!in_array($item->team, $array)){
                $array[] = $item->team;
            }
        }
        return $array;
    }
}
