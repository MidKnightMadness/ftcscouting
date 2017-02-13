<?php


namespace App\Policies;


use App\Team;
use App\TeamPermission;
use App\User;

trait PermissionPolicy {


    /**
     * Gets the default role of the team
     * @param Team $team
     * @return \App\TeamRole|mixed|null
     */
    protected function getDefaultRole(Team $team) {
        foreach ($team->roles as $role) {
            if ($role->default)
                return $role;
        }
        return null;
    }

    protected function hasPermission(Team $team, User $user, $permission) {
        $perms = TeamPermission::whereUser($user->id)->whereTeam($team->id)->orderBy('priority', 'asc')->get();
        $roles = array();
        if ($perms->count() < 1) {
            // If the user doesn't have any roles assigned to them, assume the default role
            $roles[] = $this->getDefaultRole($team);
        } else {
            foreach ($perms as $perm) {
                $roles[] = $perm->teamRole;
            }
        }
        $perm_matrix = array();
        foreach ($roles as $role) {
            foreach ($role->getAllPerms() as $p) {
                if (isset($perm_matrix[$p])) {
                    // If the permission exists, check if it's zero
                    if (!$perm_matrix[$p]) {
                        // If it's zero, set it to the current role
                        $perm_matrix[$p] = $role[$p];
                    }
                } else {
                    // If it doesn't exist in the database, just set its value
                    $perm_matrix[$p] = $role[$p];
                }
            }
        }
        $matrix = isset($perm_matrix[$permission]) ? $perm_matrix[$permission] : 0;
        return $matrix;
    }
}