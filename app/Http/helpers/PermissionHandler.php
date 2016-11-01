<?php


namespace App\Helpers;


use App\Team;
use App\TeamPermission;
use App\User;

class PermissionHandler {

    public static function getDefaultRole(Team $team) {
        foreach ($team->roles as $role) {
            if ($role->default)
                return $role;
        }
        return null;
    }

    public static function hasPermission(Team $team, User $user, $permission) {
        $perms = TeamPermission::where('user', $user->id)->where('team', $team->id)->orderBy('priority', 'asc')->get();

        if($user->data->superadmin)
            return true;

        $perm_matrix = array();
        foreach ($perms as $perm) {
            $role = $perm->teamRole;
            foreach ($role->getAllPerms() as $p) {
                if(isset($perm_matrix[$p])){
                    // If the permission exists, check if it's zero
                    if(!$perm_matrix[$p]){
                        // If it's zero, set it to the current role
                        $perm_matrix[$p] = $role[$p];
                    }
                } else {
                    // If it doesn't exist in the database, just set its value
                    $perm_matrix[$p] = $role[$p];
                }
            }
        }
        if(isset($perm_matrix[$permission]))
            return $perm_matrix[$permission];
        else
            return 0;
    }
}