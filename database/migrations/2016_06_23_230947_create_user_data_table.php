<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->timestamps();
            $table->text('bio');
            $table->boolean('superadmin')->default(false);
            $table->boolean('has_profile_photo')->default(false);
            $table->boolean('gravatar')->default(false);
            $table->string('photo_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_data');
    }
}
