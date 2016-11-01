<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamPermission extends Model
{
    protected $table = "team_permissions";

    public function teamRole(){
        return $this->hasOne('App\TeamRole', 'id', 'role');
    }
}
