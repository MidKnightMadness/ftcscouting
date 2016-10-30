<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller {

    public function getUser($username) {
        $user = User::whereName($username)->first();
        if ($user == null)
            return response()->json(['error' => 'User Not Found', 'errorno' => 1]);
        return $this->userJson($user);
    }

    public function getTeam($teamNumber) {
        $team = Team::whereTeamNumber($teamNumber)->first();
        if ($team == null)
            return response()->json(['error' => 'Team Not Found', 'errorno' => 2]);
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
