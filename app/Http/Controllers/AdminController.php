<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Jobs\ProcessTeamPIN;
use App\Match;
use App\Pim;
use App\Team;

class AdminController extends Controller {
    private $team;
    private $match;
    private $pim;

    private $pn_values = ['climbers_scored' => '1', 'beacon_scored' => '1', 'auto_zone_0' => '0', 'auto_zone_1' => '1', 'auto_zone_2' => '2',
        'auto_zone_3' => '3', 'auto_zone_4' => '4', 'auto_zone_5' => '5', 'auto_zone_6' => '6', 't_climbers_scored' => '1',
        'zl_climbers_0' => '0', 'zl_climbers_1' => '1', 'zl_climbers_2' => '2', 'zl_climbers_3' => '3', 'd_none' => '0', 'd_fz' => '1',
        'd_lz' => '1', 'd_mz' => '1', 'd_hz' => '1', 'all_clear' => '1', 'tele_park_0' => '0', 'tele_park_1' => '1', 'tele_park_2' => '2',
        'tele_park_3' => '3', 'tele_park_4' => '4', 'tele_park_5' => '5', 'tele_park_6' => '6', 'tele_park_7' => '7'];

    public function __construct(Team $team, Match $match, Pim $pim) {
        $this->team = $team;
        $this->match = $match;
        $this->pim = $pim;
    }

    public function getPinCalculate($teamNumber) {
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        $this->dispatch(new ProcessTeamPIN($team));
        echo "Calculating outstanding matches for team $teamNumber<br>";
    }

    public function getPopulatePinDatabase() {
        foreach ($this->pn_values as $k => $v) {
            echo $k . ' - ' . $v . '<br/>';
        }
        echo "------ <br/><br/>";
        foreach ($this->pn_values as $k => $v) {
            $p = $this->pim->wherePimName($k)->first();
            if ($p == null) {
                $p = new Pim();
                $p->pim_name = $k;
                $p->value = $v;
                $p->save();
                echo "Added new pim {$k} with value {$v}<br/>";
            } else {
                if ($p->value != $v) {
                    $p->value = $v;
                    $p->save();
                    echo "Updated {$k} to {$v}<br/>";
                } else {
                    echo "Not updating {$k}<br/>";
                }
            }
        }
    }

    public function getReCalculateAll(){
        $allTeams = $this->team->get();
        foreach($allTeams as $team){
            $this->getPinForceCalculate($team->team_number);
        }
    }

    public function getPinForceCalculate($teamNumber) {
        echo "Force recalculating pim for team {$teamNumber}<br/>";
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        if ($team == null) {
            echo "Team $teamNumber not found!<br/>";
            return;
        }
        $team->p_match_count = 0;
        $team->pin = 0;
        $team->raw_pin = 0;
        $team->save();

        $matches = $this->match->whereTeamId($team->id)->get();
        foreach ($matches as $match) {
            $match->pn_processed = false;
            $match->save();
        }
        $this->getPinCalculate($teamNumber);
    }
}
