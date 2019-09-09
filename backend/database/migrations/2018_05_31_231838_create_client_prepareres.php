<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPrepareres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_prepareres', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('state_bar_num');
            $table->string('USCIS_account_num');
            $table->boolean('G28');
            $table->string('street_num');
            $table->string('apt_num');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('telephone_num');
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
        Schema::drop('client_prepareres');
    }
}
