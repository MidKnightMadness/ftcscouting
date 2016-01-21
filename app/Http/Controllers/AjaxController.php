<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    private $team;

    public function __construct(Team $team){
        $this->team = $team;
    }
    public function getTeamInfo($teamNumber){
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        if($team == null){
            return response()->json(['error'=>'TEAM_NO_EXIST']);
        } else {
            return response()->json(['id'=>$team->id, 'team_name'=>$team->team_name, 'submitter'=>$team->submitter_name]);
        }
    }
}
