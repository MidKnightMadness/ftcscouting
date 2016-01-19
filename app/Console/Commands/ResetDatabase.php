<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class ResetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets the database in preparation for the next tournament';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->confirm('This will delete ALL teams and ALL match results from the database. Continue?')){
            if($this->confirm('Once deleted, these cannot be recovered. Continue?')){
                $this->info("Deleting Matches...");
                $matchCount = DB::delete("DELETE FROM `matches`");
                $this->info('Deleted '.$matchCount.' matches');
                $this->info("Deleting Teams....");
                $teams = DB::delete("DELETE FROM `TEAMS`");
                $this->info("Delted ".$teams." teams");
                $this->info("Resetting Ids");
                DB::statement("ALTER TABLE `matches` AUTO_INCREMENT = 1");
                DB::statement("ALTER TABLE `teams` AUTO_INCREMENT = 1");
            } else {
                $this->info('Aborted!');
            }
        } else {
            $this->info('Aborted!');
        }
    }
}
