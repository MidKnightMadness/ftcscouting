<?php

namespace App\Jobs;

use App\Match;
use App\Pim;
use App\Team;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Schema;

class ProcessTeamPIN extends Job implements ShouldQueue {
    use InteractsWithQueue, SerializesModels;


    private $team;

    private $excluded_cols = ['id', 'created_at', 'updated_at', 'team_id', 'pn'];

    /**
     * Create a new job instance.
     *
     * @param Team $team
     */
    public function __construct(Team $team) {
        $this->team = $team;
    }

    /**
     * Execute the job.
     *
     * @param Match $match
     * @param Pim $pim
     */
    public function handle(Match $match, Pim $pim) {
        // Get all column names
        $cols = Schema::getColumnListing($match->getTable());
        $matches = $match->whereTeamId($this->team->id)->get();
        $total_pim = $this->team->raw_pin;
        $match_count = $this->team->p_match_count;
        Log::info("");
        Log::info("");
        Log::info("");
        Log::info("");
        Log::info("\t {$this->team->team_number}");
        Log::info("Starting info: [M] " . $match_count . " [total_pim] " . $total_pim);
        foreach ($matches as $match) {
            $match_pn = 0;
            if ($match->pn_processed)
                continue;
            Log::info("----- New Match ------");
            foreach ($cols as $col) {
                if (in_array($col, $this->excluded_cols)) {
                    continue;
                }
                $pin_val = $col;
                if ($col == 'auto_zone' || $col == 'tele_park' || $col == 'zl_climbers') {
                    $pin_val = "{$col}_" . $match->{$col};
                    Log::info("New special pn: $pin_val");
                }
                // Get the col's pn
                $p = $pim->wherePimName($pin_val)->first();
                if ($p == null) {
                    Log::info("No Pim entry for " . $col);
                    continue;
                }
                if ($p->value == 'db') {
                    Log::info('Retrieving pn value from database...');
                    $pn = $match->{$col};
                    Log::info('Retrieved value: ' . $pn);
                    $match_pn += $pn;
                }
                $match_pn += $p->value;
            }
            $match->pn = $match_pn;
            $match->pn_processed = true;
            $match->save();
            Log::info("Match PN: " . $match_pn);
            $total_pim += $match_pn;
            $match_count++;
        }
        $this->team->raw_pin = $total_pim;
        if ($match_count == 0)
            $avg_pin = 0;
        else
            $avg_pin = floor($total_pim / $match_count);
        $this->team->pin = $avg_pin;
        $this->team->p_match_count = $match_count;
        Log::info("Results: raw_pin: " . $total_pim . ", pin: " . $avg_pin . ", match_count: " . $match_count);
        $this->team->save();
    }
}
