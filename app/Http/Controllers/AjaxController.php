<?php

namespace App\Http\Controllers;

use App\Match;
use App\Team;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AjaxController extends Controller
{
    private $team;
    private $match;
    public function __construct(Match $match, Team $team){
        $this->team = $team;
        $this->match = $match;
    }
    public function getTeamInfo($teamNumber){
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        if($team == null){
            return response()->json(['error'=>'TEAM_NO_EXIST']);
        } else {
            return response()->json(['id'=>$team->id, 'team_name'=>$team->team_name, 'submitter'=>$team->submitter_name]);
        }
    }

    public function getMatchInfo($teamNumber, $matchNum){
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        if($team == null)
            return response()->json(['error'=>'TEAM_NO_EXIST']);
        else{
            $match = $this->match->whereTeamId($team->id)->whereMatchNum($matchNum)->first();
            if($match == null){
                return response()->json(['error'=>'MATCH_NO_EXIST']);
            } else{
                return response()->json(['error'=>'SUCCESS']);
            }
        }
    }
}
