<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamInvite extends Model
{
    protected $table = 'team_invites';
    
    protected $guarded = [];
    
    
    public function recUser(){
        return $this->hasOne('App\User', 'id', 'receiver');
    }
    
    public function sendUser(){
        return $this->hasOne('App\User', 'id', 'sender');
    }

    public function team(){
        return $this->hasOne('App\Team', 'id', 'team_id');
    }
}
