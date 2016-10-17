<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;
use Log;

class ApiController extends Controller
{

    public function getUser($username){
        $user = User::whereName($username)->first();
        if($user == null)
            return response()->json(['error'=>'User Not Found', 'errorno'=>1]);
        $userData = $user->data;
        return ['id'=>$user->id,
            'name'=>$user->name,
            'created_at'=>$user->created_at->toDateTimeString(),
            'data'=>[
                'bio'=>$userData->bio,
                'photo_location'=>$user->getProfilePicUrl(150)
            ]
        ];
    }

    public function getTeam($teamNumber){
        $team = Team::whereTeamNumber($teamNumber)->first();
        if($team == null)
            return response()->json(['error'=>'Team Not Found', 'errorno'=>2]);
        return response()->json($team);
    }

    public function getTeams(){
        return response()->json(Team::all());
    }

    public function teamMembers($teamNumber, Request $request){
        $team = Team::whereTeamNumber($teamNumber)->first();
        $user = $request->user();
        $users = array();
        Log::info("Fetching members for $teamNumber");
        foreach($team->members as $invite){
            if(!$invite->pending && !$invite->accepted)
                continue;
            if(!$invite->public){
                if($invite->recUser->teamInCommon($user, $team->id)){
                    $users[] = [
                        'invite_id'=>$invite->id,
                        'user'=>$invite->recUser->name,
                        'private'=>1,
                        'pending'=>$invite->pending
                    ];
                }
            } else {
                $users[] = [
                    'invite_id'=>$invite->id,
                    'user'=>$invite->recUser->name,
                    'private'=>0,
                    'pending'=>$invite->pending
                ];
            }
        }
        return $users;
    }
}
