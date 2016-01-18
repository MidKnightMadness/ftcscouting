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
            $table->string('submitterName');
            $table->string('teamName');
            $table->integer('teamNumber')->unique();
            $table->text('startingLoc');
            $table->integer('climbersScored');
            $table->boolean('beaconScored');
            $table->text('autoZone');
            $table->boolean('t_climberScored');
            $table->integer('zl_climbers');
            $table->boolean('d_none');
            $table->boolean('d_fz');
            $table->boolean('d_lz');
            $table->boolean('d_mz');
            $table->boolean('d_hz');
            $table->boolean('allClear');
            $table->boolean('lz_f');
            $table->boolean('lz');
            $table->boolean('mz');
            $table->boolean('hz');
            $table->boolean('hang');
            $table->text('otherInfo');
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
