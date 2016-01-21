<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMatchesAddSubmitterName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('matches', function(Blueprint $table){
            $table->text('submitter_name');
            $table->integer('match_num');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matches', function(Blueprint $table){
            $table->dropColumn('submitter_name');
            $table->dropColumn('match_num');
        });
    }
}
