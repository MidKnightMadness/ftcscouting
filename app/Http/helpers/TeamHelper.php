<?php


namespace App\Helpers;


use App\Team;
use App\TeamInvite;
use App\User;

class TeamHelper {

    public function getTeamsForUser(User $user) {
        return $this->getTeamsForId($user->id);
    }

    public function getTeamsForId($id) {
        $teams = array();
        $teamInvites = TeamInvite::whereReceiver($id)->whereAccepted(true)->get();
        foreach ($teamInvites as $team) {
            $teams[] = Team::whereId($team->team_id)->first();
        }
        return $teams;
    }

    public function getAllTeams() {
        return Team::all();
    }

}