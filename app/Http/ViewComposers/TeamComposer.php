<?php


namespace App\Http\ViewComposers;


use App\Team;
use App\TeamInvite;
use Auth;
use Illuminate\Contracts\View\View;
use Log;

class TeamComposer {


    protected $teams;
    protected $teamInvite;

    public function __construct(Team $teams, TeamInvite $teamInvite) {
        $this->teams = $teams;
        $this->teamInvite = $teamInvite;
    }

    public function compose(View $view) {
        $view->with('teams', $this->teams->orderBy('team_number')->get());
        if (Auth::guest()) {
            $view->with('user_teams', array());
            $view->with('pending_teams', array());
        } else {
            $user = Auth::user();
            $teamInvites = $this->teamInvite->whereReceiver($user->id)->whereAccepted(true)->get();
            $user_teams = array();
            foreach ($teamInvites as $invite) {
                $user_teams[] = $invite->team;
            }
            $view->with('user_teams', $user_teams);
            
            $pendingInvites = $this->teamInvite->whereReceiver($user->id)->whereAccepted(false)->wherePending(true)->get();
            $pending = array();
            foreach($pendingInvites as $pending_invite){
                $pending[$pending_invite->id] = $pending_invite->team;
            }
            $view->with('pending_teams', $pending);
        }
    }
}