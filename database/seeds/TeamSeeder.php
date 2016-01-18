<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed 75 teams
        for($i = 0; $i < 75; $i++){
            $teamName = str_random('10');
            $teamNumber = rand(1000, 3000);
            $startingLoc = str_random('10');
            $climbersScored = rand(0, 1);
            $beaconScored = rand(0, 1);
            $autoZone = rand(0, 3);
            $t_climbScored = rand(0, 1);
            $zlClimbers = rand(0, 3);
            $d_f = rand(0, 1);
            $d_l = rand(0, 1);
            $d_m = rand(0, 1);
            $d_h = rand(0, 1);
            $ac = rand(0, 1);
            $hang = rand(0, 1);
            $lz_f = rand(0, 1);
            $lz = rand(0, 1);
            $mz = rand(0, 1);
            $hz = rand(0, 1);
            \App\Team::create(['submitter_name'=>str_random(), 'team_name'=>$teamName, 'team_number' =>$teamNumber, 'starting_loc'=>$startingLoc, 'climbers_scored'=>$climbersScored,
            'beacon_scored' =>$beaconScored, 'auto_zone' => $autoZone, "t_climbers_scored" =>$t_climbScored, 'zl_climbers'=>$zlClimbers, 'd_none' => '',
            'd_fz'=>$d_f, 'd_lz'=>$d_l, 'd_mz'=>$d_m, 'd_hz'=>$d_h, 'all_clear'=>$ac, 'lz_f'=>$lz_f, 'lz'=>$lz, 'mz'=>$mz, 'hz'=>$hz, 'hang'=>$hang]);
        }
    }
}
