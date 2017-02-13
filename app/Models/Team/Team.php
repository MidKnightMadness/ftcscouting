<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    protected $table = 'teams';

    protected $guarded = [];


    public function members() {
        return $this->hasMany('App\TeamInvite');
    }

    public function surveys() {
        return $this->hasMany('App\Survey')->where('archived', '=', '0');
    }

    public function surveysWithArchived(){
        return $this->hasMany('App\Survey');
    }

    public function roles(){
        return $this->hasMany('App\TeamRole');
    }

    public function isOwner($userId){
        return $this->owner_id == $userId;
    }
}
