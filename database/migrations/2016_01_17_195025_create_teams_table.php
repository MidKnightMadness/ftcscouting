<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('submitter_name');
            $table->string('team_name');
            $table->integer('team_number')->unique();
            $table->boolean('starting_loc');
            $table->integer('climbers_scored');
            $table->boolean('beacon_scored');
            $table->text('auto_zone');
            $table->boolean('t_climbers_scored');
            $table->integer('zl_climbers');
            $table->boolean('d_none');
            $table->boolean('d_fz');
            $table->boolean('d_lz');
            $table->boolean('d_mz');
            $table->boolean('d_hz');
            $table->boolean('all_clear');
            $table->boolean('lz_f');
            $table->boolean('lz');
            $table->boolean('mz');
            $table->boolean('hz');
            $table->boolean('hang');
            $table->text('other_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teams');
    }
}
