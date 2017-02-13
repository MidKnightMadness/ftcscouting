<?php


namespace App\Http\ViewComposers;


use App\Team;
use App\TeamInvite;
use Auth;
use Illuminate\Contracts\View\View;

class TeamComposer {


    protected $teams;
    protected $teamInvite;

    public function __construct(Team $teams, TeamInvite $teamInvite) {
        $this->teams = $teams;
        $this->teamInvite = $teamInvite;
    }

    public function compose(View $view) {
        $view->with('teams', Team::orderBy('team_number')->get());
        if (Auth::guest()) {
            $view->with('user_teams', array());
            $view->with('pending_teams', array());
        } else {
            $user = Auth::user();
            $teamInvites = TeamInvite::whereReceiverId($user->id)->with('team')->get();
            $teams = array();
            $pending_teams = array();
            foreach ($teamInvites as $invite) {
                if ($invite->pending) {
                    $pending_teams[] = $invite->team;
                } else {
                    $teams[] = $invite->team;
                }
            }
            $view->with('user_teams', $teams);
            $view->with('pending_teams', $pending_teams);
        }
    }
}