<?php

namespace App\Http\Controllers;

use App\Team;
use App\TeamInvite;
use App\TeamRole;
use Illuminate\Http\Request;
use Validator;

class TeamController extends Controller {

    private $team;

    public function __construct(Team $team) {
        $this->team = $team;
    }

    public function showAllTeams() {
        return view('team.all');
    }

    public function showCreate() {
        return view('team.create');
    }

    public function doCreate(Request $request) {
        Validator::replacer('unique', function ($message, $attribute, $rule, $parameters) {
            if ($attribute == 'team-number') {
                return "That team has already been registered";
            }
            return $message;
        });
        $this->validate($request, ['team-number' => 'required|numeric|unique:teams,team_number',
            'team-name' => 'required']);
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
        // Create the default team roles
        $default = new TeamRole;
        $default->name = "Default";
        $default->default = true;
        $default->owning_team = $team->id;
        $default->save();

        return redirect()->route('teams.all')->with(['message' => 'Team created successfully', 'message_type' => 'success']);
    }

    public function viewTeam($number) {
        $team = $this->team->whereTeamNumber($number)->firstOrFail();
        $members = array();
        foreach ($team->members as $invite) {
            if ($invite->recUser->id == $team->owner) {
                if ($invite->public)
                    array_unshift($members, $invite->recUser);
                else if (!\Auth::guest() && \Auth::user()->teamInCommon($invite->recUser, $team->id))
                    array_unshift($members, $invite->recUser);
                continue;
            }
            if ($invite->pending || !$invite->accepted)
                continue;
            if ($invite->public) {
                $members[] = $invite->recUser;
            } else {
                // The member is private, only show if they share the team
                if (!\Auth::guest()) {
                    if (\Auth::user()->teamInCommon($invite->recUser, $team->id)) {
                        $members[] = $invite->recUser;
                    }
                }
            }
        }

        return view('team.view', compact('team', 'members', 'owner'));
    }

    public function manageTeam($number) {
        $team = $this->team->whereTeamNumber($number)->firstOrFail();
        if(\Auth::guest() || !\Auth::user()->can('manage', $team)){
            return redirect(route('teams.show', [$number]))->with(['message'=>'Error:You cannot manage teams', 'message_type'=>'danger']);
        }
        return view('team.manage', compact('team'));
    }

    public function acceptTeamInvite($inviteNumber) {
        $teamInvite = TeamInvite::whereId($inviteNumber)->first();
        if ($teamInvite == null) {
            return back()->with(['message' => 'Error:That invite does not exist!', 'message_type' => 'danger']);
        }
        $teamInvite->pending = false;
        $teamInvite->accepted = true;
        $teamInvite->save();
        $team = $this->team->whereId($teamInvite->team_id)->first();
        return back()->with(['message' => 'Success:You are not a member of Team ' . $team->team_number, 'message_type' => 'success']);
    }

    public function postAcceptTeamInvite($teamId) {
        $team = $this->team->whereId($teamId)->first();
        if ($team == null) {
            return back()->with(['message' => 'Error:That team does not exist!', 'message_type' => 'danger']);
        }
        if (\Auth::guest()) {
            return back()->with(['message' => 'Error:You must be logged in to do that', 'message_type' => 'danger']);
        }
        $invites = TeamInvite::whereTeamId($teamId)->whereReceiver(\Auth::user()->id)->get();
        if ($invites == null || count($invites) == 0) {
            return back()->with(['message' => 'Error:You don\'t have any invites for this team', 'message_type' => 'danger']);
        }
        foreach ($invites as $invite) {
            $invite->pending = false;
            $invite->accepted = true;
            $invite->save();
        }
        return back()->with(['message' => 'Success:You have joined Team ' . $team->team_number . ' successfully!', 'message_type' => 'success']);
    }
}
