<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->string('question_id')->primary();
            $table->string('survey_id');
            $table->integer('order');
            $table->string('question_name', 1500);
            $table->enum('question_type', ['short_text', 'long_text', 'number', 'checkbox', 'radio']);
            $table->string('extra_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}
