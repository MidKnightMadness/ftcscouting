<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    protected $table = 'teams';

    protected $guarded = [];


    public function members() {
        return $this->hasMany('App\TeamInvite', 'team_id', 'id');
    }
}
