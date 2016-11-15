<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->integer('owning_team');
            $table->boolean('default')->default(true);
            $table->boolean('team_owner')->default(false);
            $table->boolean('manage_team')->default(false);
            $table->boolean('invite_member')->default(false);
            $table->boolean('remove_member')->default(false);

            $table->boolean('survey_view')->default(true);
            $table->boolean('survey_create')->default(false);
            $table->boolean('survey_modify')->default(false);
            $table->boolean('survey_delete')->default(false);
            $table->boolean('survey_respond')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_roles');
    }
}
