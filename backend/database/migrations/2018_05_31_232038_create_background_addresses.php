<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackgroundAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('background_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address_type');
            $table->string('street_num');
            $table->string('city_town');
            $table->string('department_province_state');
            $table->string('country');
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::drop('background_addresses');
    }
}
