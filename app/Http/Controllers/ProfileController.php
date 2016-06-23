<?php

namespace App\Http\Controllers;

use App\Helpers\TeamHelper;
use App\User;

use App\Http\Requests;

class ProfileController extends Controller
{


    public function profile($userName, TeamHelper $teamHelper){
        $user = User::whereName($userName)->first();
        $part_of = $teamHelper->getTeamsForUser($user);
        return view('profile.profile', compact('user', 'part_of'));
    }

    public function edit(){
        $user = \Auth::user();
    }
}
