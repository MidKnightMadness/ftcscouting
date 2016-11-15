<?php

namespace App\Policies;

use App\Team;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy {
    use HandlesAuthorization, PermissionPolicy;

    public function before(User $user, $ability, Team $team) {
        if ($user->data->superadmin) {
            return true;
        }
        if ($team->isOwner($user->id)) {
            return true;
        }
    }


    public function manage(User $user, Team $team) {
        return $this->hasPermission($team, $user, 'manage_team');
    }

    public function invite(User $user, Team $team) {
        return $this->hasPermission($team, $user, 'invite_member');
    }

    public function remove_member(User $user, User $toRemove, Team $team) {
        if ($team->isOwner($toRemove->id))
            return false;
        if ($user->id == $toRemove)
            return false;
        return $this->hasPermission($team, $user, 'remove_member');
    }

    public function edit_survey(User $user, Team $team) {
        return $this->hasPermission($team, $user, 'survey_modify');
    }

    public function view_survey(User $user, Team $team) {
        return $this->hasPermission($team, $user, 'survey_view');
    }

    public function create_survey(User $user, Team $team) {
        return $this->hasPermission($team, $user, 'survey_create');
    }

    public function delete_survey(User $user, Team $team) {
        return $this->hasPermission($team, $user, 'survey_delete');
    }

    public function survey_respond(User $user, Team $team) {
        return $this->hasPermission($team, $user, 'survey_respond');
    }
}
