<?php

namespace App\Http\Controllers;

use App\Team;
use App\TeamInvite;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller {

    public function getUser($username) {
        $user = User::whereName($username)->first();
        if ($user == null)
            return response()->json(['error' => 'User Not Found'], 404);
        return $this->userJson($user);
    }

    public function getTeam($teamNumber) {
        $team = Team::whereTeamNumber($teamNumber)->first();
        if ($team == null)
            return response()->json(['error' => 'Team Not Found'], 404);
        return response()->json($team);
    }

    public function getTeams() {
        return response()->json(Team::all());
    }

    public function teamMembers($teamNumber, Request $request) {
        $team = Team::whereTeamNumber($teamNumber)->first();
        $user = $request->user();
        $users = array();
        foreach ($team->members as $invite) {
            if (!$invite->pending && !$invite->accepted)
                continue;
            $data = array();
            $data['invite_id'] = $invite->id;
            $data['user'] = $this->userJson($invite->recUser);
            $data['pending'] = $invite->pending;
            if (!$invite->public) {
                if ($invite->recUser->teamInCommon($user, $team->id)) {
                    $data['private'] = 1;
                    $users[] = $data;
                }
            } else {
                $data['private'] = 0;
                $users[] = $data;
            }
        }
        return $users;
    }

    public function sendInvite(Request $request){
        $sendingUser = $request->user();
        $toInvite = $request->username;
        $teamNumber = $request->teamNumber;
        // Check if the user is already on the team
        $team = Team::whereTeamNumber($teamNumber)->first();
        $alreadyOnTeam = false;
        foreach ($team->members as $invite){
            if($invite->recUser->name == $toInvite) {
                if(!$invite->pending && !$invite->accepted)
                    continue;
                $alreadyOnTeam = true;
                break;
            }
        }
        if($alreadyOnTeam){
            return response()->json(['error'=>"$toInvite is already invited!"], 400);
        }

        $inv = new TeamInvite();
        $inv->accepted = false;
        $inv->pending = true;
        $inv->sender = $sendingUser->id;
        $inv->receiver = User::whereName($toInvite)->first()->id;
        $inv->team_id = $team->id;
        $inv->save();
        return response()->json(['status'=>'Invite Sent!']);
    }

    public function cancelInvite(Request $request){
        $invite = TeamInvite::whereId($request->id);
        if($invite == null){
            return response()->json(['error'=>'That invite does not exist!'], 404);
        }
        $invite->delete();
        return response()->json(['status'=>'Deleted!']);
    }

    private function userJson(User $user) {
        return ['id' => $user->id,
            'name' => $user->name,
            'created_at' => $user->created_at->toDateTimeString(),
            'data' => [
                'bio' => $user->data->bio,
                'photo_location' => $user->getProfilePicUrl(150)
            ]
        ];
    }
}
