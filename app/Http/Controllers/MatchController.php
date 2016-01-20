<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTeamPIN;
use App\Match;
use App\Pim;
use App\Team;
use Illuminate\Http\Request;
use Log;
use Schema;

class MatchController extends Controller {

    private $match;
    private $team;

    private $pn_values = ['climbers_scored'=>'1', 'beacon_scored'=>'1', 'auto_zone'=>'db', 't_climbers_scored'=>'1',
    'zl_climbers'=>'db', 'd_none'=>'0', 'd_fz'=>'1', 'd_lz'=>'1', 'd_mz'=>'1', 'd_hz'=>'1', 'all_clear'=>'1', 'tele_park'=>'db'];

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
        $m = $match->create($request->except('team_number'));
        $m->team_id = $team->id;
        $m->save();
        // Calculate a team's PIN (Performance Indicator Number
        Log::info('Dispatching PIN calculation');
        $this->dispatch(new ProcessTeamPIN($team));
        return redirect(route('match.details') . '/' . $team->id)->with(['alert_msg' => 'Match recorded!', 'alert_msg_type' => 'success']);
    }

    public function getPimCalculate($teamNumber){
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        $this->dispatch(new ProcessTeamPIN($team));
        echo "Success!";
    }

    public function getPimForceCalculate($teamNumber){
        echo "Force recalculating pim for team {$teamNumber}<br/>";
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        $team->p_match_count = 0;
        $team->pin = 0;
        $team->raw_pin = 0;
        $team->save();

        $matches = $this->match->whereTeamId($team->id)->get();
        foreach($matches as $match){
            $match->pn_processed = false;
            $match->save();
        }
        $this->getPimCalculate($teamNumber);
    }

    public function getPopulatePimDatabase(Pim $pim){
        foreach($this->pn_values as $k => $v){
            echo $k.' - '.$v.'<br/>';
        }
        echo "------ <br/><br/>";
        foreach($this->pn_values as $k => $v){
            $p = $pim->wherePimName($k)->first();
            if($p == null){
                $p = new Pim();
                $p->pim_name = $k;
                $p->value = $v;
                $p->save();
                echo "Added new pim {$k} with value {$v}<br/>";
            } else {
                if($p->value != $v) {
                    $p->value = $v;
                    $p->save();
                    echo "Updated {$k} to {$v}<br/>";
                } else {
                    echo "Not updating {$k}<br/>";
                }
            }
        }
    }

    private function noMatch($team, $match) {
        if ($match != $team && $team) {
            return "<td class=\"danger\">";
        } else {
            return "<td>";
        }
    }

    private function compareAutoZone($team, $match) {
        if ($team > $match) {
            return "<td class=\"danger\">";
        }
        return "<td>";
    }

    private function getYesNo($cond) {
        return $cond ? 'Yes' : 'No';
    }

    private function getParkLoc($parkLocId) {
        switch ($parkLocId) {
            case 0:
                return "N/A";
                break;
            case 1:
                return "Floor Goal";
                break;
            case 2:
                return "Repair Zone";
                break;
            case 3:
                return "Low Zone touching Floor";
                break;
            case 4:
                return "Low Zone";
                break;
            case 5:
                return "Mid Zone";
                break;
            case 6:
                return "High Zone";
                break;
            case 7:
                return "Hang";
                break;
            default:
                return "";
        }
    }

    private function constructMatches($team, $matches) {
        $rows = array();
        foreach ($matches as $match) {
            $string = "";
            $string .= $this->noMatch($team->climbers_scored, $match->climbers_scored);
            $string .= $this->getYesNo($match->climbers_scored);
            $string .= "</td>";

            $string .= $this->noMatch($team->beacon_scored, $match->beacon_scored);
            $string .= $this->getYesNo($match->beacon_scored);
            $string .= "</td>";

            $string .= $this->compareAutoZone($team->auto_zone, $match->auto_zone);
            $string .= $this->getParkLoc($match->auto_zone);
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

            $string .= "<td>";
            $string .= $this->getParkLoc($match->tele_park);
            $string .= "</td>";

            $string .= $this->noMatch($team->all_clear, $match->all_clear);
            $string .= $this->getYesNo($match->all_clear);
            $string .= "</td>";

            $string .= "<td>" . $match->pn . "</td>";

            array_push($rows, $string);
        }
        return $rows;
    }
}
