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
            $table->string('beaconScored');
            $table->text('autoZone');
            $table->string('t_climberScored');
            $table->integer('zl_climbers');
            $table->string('d_none');
            $table->string('d_fz');
            $table->string('d_lz');
            $table->string('d_mz');
            $table->string('d_hz');
            $table->string('allClear');
            $table->string('lz_f');
            $table->string('lz');
            $table->string('mz');
            $table->string('hz');
            $table->string('hang');
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
