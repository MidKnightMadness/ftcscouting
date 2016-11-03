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
            $table->string('response_id')->primary();
            $table->string('response_group_id');
            $table->string('question_id');
            $table->string('response', 1500);
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
