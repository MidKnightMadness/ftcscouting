<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamInvite extends Model
{
    protected $table = 'team_invites';
    
    protected $guarded = [];
    
    
    public function receiver(){
        return $this->belongsTo(\App\User::class);
    }
    
    public function sender(){
        return $this->belongsTo(\App\User::class);
    }

    public function team(){
        return $this->belongsTo(\App\Team::class);
    }
}
