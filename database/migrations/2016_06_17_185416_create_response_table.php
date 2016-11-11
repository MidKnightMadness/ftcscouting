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
        Schema::create('allResponses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('survey');
            $table->boolean('initial');
            $table->integer('submitted_by');
            $table->integer('team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('allResponses');
    }
}
