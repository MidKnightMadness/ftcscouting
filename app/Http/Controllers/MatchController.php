<?php

namespace App\Http\Controllers;

use App\Match;
use App\Team;
use Illuminate\Http\Request;

class MatchController extends Controller {

    private $match;
    private $team;

    public function __construct(Team $team, Match $match) {
        $this->match = $match;
        $this->team = $team;
    }

    public function getIndex() {
        return \Redirect::route('team.list');
    }

    public function getDetails($teamId) {
        $team = $this->team->whereId($teamId)->first();
        $matches = $this->constructMatches($team, $this->match->whereTeamId($teamId)->get());
        return view('match.team', compact('team', 'matches'));
    }

    public function getNew() {
        return view('match.new');
    }

    public function putSave(Match $match, Request $request) {
        $team = $this->team->whereTeamNumber($request->input('team_number'))->first();
        if ($team == null)
            return \Redirect::back()->with(['alert_msg' => 'That team does not exist', 'alert_msg_type' => 'danger'])->withInput();
        $match->team_id = $team->id;
        $match->create($request->except('team_number'));
        $match->save();
        return \Redirect::route('match.add')->with(['alert_msg' => 'Match results recorded successfully', 'alert_msg_type' => 'success']);
    }

    private function noMatch($team, $match) {
        if ($match != $team && $team) {
            return "<td class=\"danger\">";
        } else {
            return "<td>";
        }
    }

    private function getYesNo($cond) {
        return $cond ? 'Yes' : 'No';
    }

    private function constructMatches($team, $matches) {
        $rows = array();
        $string = "";
        foreach ($matches as $match) {
            $string .= $this->noMatch($team->climbers_scored, $match->climbers_scored);
            $string .= $this->getYesNo($match->climbers_scored);
            $string .= "</td>";

            $string .= $this->noMatch($team->beacon_scored, $match->beacon_scored);
            $string .= $this->getYesNo($match->beacon_scored);
            $string .= "</td>";

            $string .= $this->noMatch($team->t_climbers_scored, $match->t_climbers_scored);
            $string .= $this->getYesNo($match->t_climbers_scored);
            $string .= "</td>";

            $string .= $this->noMatch($team->zl_climbers, $match->zl_climbers);
            $string .= $match->zl_climbers;
            $string .= "</td>";

            $string .= $this->noMatch($team->d_none, $team->d_none);
            $string .= $this->getYesNo($team->d_none);
            $string .= "</td>";

            $string .= $this->noMatch($team->d_fz, $match->d_fz);
            $string .= $this->getYesNo($match->d_fz);
            $string .= "</td>";

            $string .= $this->noMatch($team->d_lz, $match->d_lz);
            $string .= $this->getYesNo($match->d_lz);
            $string .= "</td>";

            $string .= $this->noMatch($team->d_mz, $match->d_mz);
            $string .= $this->getYesNo($match->d_mz);
            $string .= "</td>";

            $string .= $this->noMatch($team->d_hz, $match->d_hz);
            $string .= $this->getYesNo($match->d_hz);
            $string .= "</td>";

            $string .= $this->noMatch($team->all_clear, $match->all_clear);
            $string .= $this->getYesNo($match->all_clear);
            $string .= "</td>";

            $string .= $this->noMatch($team->hang, $match->hang);
            $string .= $this->getYesNo($match->hang);
            $string .= "</td>";

            array_push($rows, $string);
        }
        return $rows;
    }
}
