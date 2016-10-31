<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSurveyTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('surveys', function (Blueprint $table) {
            $table->string('survey_id')->primary();
            $table->integer('created_by');
            $table->integer('team_owner');
            $table->string('name');
            $table->boolean('public');
            $table->boolean('template');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('surveys');
    }
}
