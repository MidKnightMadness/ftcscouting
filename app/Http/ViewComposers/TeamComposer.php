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
        } else {
            $user = Auth::user();
            $teamInvites = $this->teamInvite->whereReceiver($user->id)->whereAccepted(true)->get();
            $user_teams = array();
            foreach ($teamInvites as $team) {
                $user_teams[] = $this->teams->whereId($team->team_id)->first();
            }
            $view->with('user_teams', $user_teams);
        }
    }
}