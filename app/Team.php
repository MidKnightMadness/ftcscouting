<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    protected $table = 'teams';

    protected $guarded = [];


    public function members() {
        return $this->hasMany('App\TeamInvite', 'team_id', 'id');
    }

    public function surveys() {
        return $this->hasMany('App\Survey', 'team_owner', 'id');
    }

    public function roles(){
        return $this->hasMany('App\TeamRole', 'owning_team', 'id');
    }

    public function isOwner($userId){
        return $this->owner == $userId;
    }
}
