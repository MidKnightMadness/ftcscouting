<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTeamPIN;
use App\Match;
use App\Pim;
use App\Team;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    private $team;
    private $match;
    private $pim;

    private $pn_values = ['climbers_scored'=>'1', 'beacon_scored'=>'1', 'auto_zone'=>'db', 't_climbers_scored'=>'1',
        'zl_climbers'=>'db', 'd_none'=>'0', 'd_fz'=>'1', 'd_lz'=>'1', 'd_mz'=>'1', 'd_hz'=>'1', 'all_clear'=>'1', 'tele_park'=>'db'];

    public function __construct(Team $team, Match $match, Pim $pim){
        $this->team = $team;
        $this->match = $match;
        $this->pim = $pim;
    }

    public function getPinCalculate($teamNumber){
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        $this->dispatch(new ProcessTeamPIN($team));
        echo "Calculating outstanding matches for team $teamNumber";
    }

    public function getPopulatePinDatabase(){
        foreach($this->pn_values as $k => $v){
            echo $k.' - '.$v.'<br/>';
        }
        echo "------ <br/><br/>";
        foreach($this->pn_values as $k => $v){
            $p = $this->pim->wherePimName($k)->first();
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

    public function getPinForceCalculate($teamNumber){
        echo "Force recalculating pim for team {$teamNumber}<br/>";
        $team = $this->team->whereTeamNumber($teamNumber)->first();
        if($team == null){
            echo "Team $teamNumber not found!<br/>";
            return;
        }
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
}
