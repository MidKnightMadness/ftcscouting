<?php


namespace App\Helpers;


use App\Team;
use App\TeamInvite;
use App\User;

class TeamHelper {

    /**
     * Returns a list of all the teams the currently logged in user is a member of
     * @return array
     */
    public function teams() {
        if (\Auth::guest())
            return array();
        $user = \Auth::user();
        $teamInvites = TeamInvite::whereReceiverId($user->id)->whereAccepted(true)->with('team', 'team.surveys')->get();
        $teams = array();
        foreach ($teamInvites as $invite) {
            $teams[] = $invite->team;
        }
        return $teams;
    }

    /**
     * Returns a list of invites the currently logged in user has
     * @return array
     */
    public function invites() {
        if (\Auth::guest())
            return array();
        $user = \Auth::user();
        $teamInvites = TeamInvite::whereReceiverId($user->id)->whereAccepted(false)->wherePending(true)->with('team')->get();
        $teams = array();
        foreach ($teamInvites as $invite) {
            $teams[] = $invite->team;
        }
        return $teams;
    }

    /**
     * Checks if the user is a member of the given team
     * @param Team $team
     * @param User|null $user
     * @return bool
     */
    public function member(Team $team, User $user = null) {
        if ($user == null) {
            if (\Auth::guest())
                return false;
            $user = \Auth::user();
        }
        return TeamInvite::whereTeamId($team->id)->whereReceiverId($user->id)->whereAccepted(true)->exists();
    }
}