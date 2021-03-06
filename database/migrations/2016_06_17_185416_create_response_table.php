<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateResponseTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('responses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('survey');
            $table->boolean('initial');
            $table->integer('submitted_by');
            $table->integer('team');
            $table->integer('match_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('responses');
    }
}
