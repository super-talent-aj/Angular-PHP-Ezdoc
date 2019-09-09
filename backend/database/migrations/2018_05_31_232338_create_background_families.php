<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackgroundFamilies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('background_families', function (Blueprint $table) {
            $table->increments('id');
            $table->string('family_type');
            $table->string('family_name');
            $table->string('family_birth_city_country');
            $table->boolean('deceased');
            $table->string('location');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('background_families');
    }
}
