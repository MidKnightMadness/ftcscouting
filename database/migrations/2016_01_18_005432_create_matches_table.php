<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('team_id');
            $table->integer('climbers_scored');
            $table->string('beacon_scored');
            $table->boolean('t_climbers_scored');
            $table->integer('zl_climbers');
            $table->boolean('d_none');
            $table->boolean('d_fz');
            $table->boolean('d_lz');
            $table->boolean('d_mz');
            $table->boolean('d_hz');
            $table->boolean('all_clear');
            $table->boolean('hang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matches');
    }
}
