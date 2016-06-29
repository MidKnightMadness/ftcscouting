<?php

namespace App\Http\Controllers;

use App\Team;

use App\Http\Requests;
use App\TeamInvite;
use Illuminate\Http\Request;
use Validator;

class TeamController extends Controller
{

    private $team;

    public function __construct(Team $team) {
        $this->team = $team;
    }

    public function showAllTeams(){
        return view('team.all');
    }
    
    public function showCreate(){
        return view('team.create');
    }

    public function doCreate(Request $request){
        Validator::replacer('unique', function($message, $attribute, $rule, $parameters) {
            if ($attribute == 'team-number') {
                return "That team has already been registered";
            }
            return $message;
        });
        $this->validate($request, ['team-number' =>'required|numeric|unique:teams,team_number',
        'team-name'=>'required']);
        $team = new Team();
        $user = \Auth::user();
        $team->name = $request->get('team-name');
        $team->team_number = $request->get('team-number');
        $team->owner = $user->id;
        $team->save();

        $team_id = $team->id;
        // Create a team invite for the user.
        $invite = new TeamInvite();
        $invite->team_id = $team_id;
        $invite->sender = $user->id;
        $invite->receiver = $user->id;
        $invite->pending = false;
        $invite->accepted = true;
        $invite->save();
        return redirect()->route('teams.all')->with(['message'=>'Team created successfully', 'message_type'=>'success']);
    }
    
    public function viewTeam($number){
        $team = $this->team->whereTeamNumber($number)->first();
        return view('team.view', compact('team'));
    }
}
