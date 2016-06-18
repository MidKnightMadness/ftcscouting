<?php

namespace App\Http\Controllers;

use App\Team;

use App\Http\Requests;

class TeamController extends Controller
{

    private $team;

    public function __construct(Team $team) {
        $this->team = $team;
    }

    public function showAllTeams(){
        return view('team.all');
    }
}
