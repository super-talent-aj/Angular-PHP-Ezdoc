<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('relation_type');
            $table->string('alien_reg_num');
            $table->string('passport_num');
            $table->string('us_social_security_num');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('maiden_aliase_name')->nullable();
            $table->date('birth_date');
            $table->string('birth_city_country');
            $table->string('nationality');
            $table->string('race_ethnic_tribal_group');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->boolean('us_person');
            $table->string('location');
            $table->date('entry_date');
            $table->string('entry_place');
            $table->string('entry_status');
            $table->string('i94_num');
            $table->string('last_admitted_status');
            $table->date('entry_status_expires');
            $table->boolean('immigration_court_proceeding')->default(true);
            $table->boolean('include_application')->default(true);
            $table->date('marriage_date')->nullable();
            $table->string('marriage_place')->nullable();
            $table->date('previous_arrival_date')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->default('single');
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
        Schema::drop('client_relationships');
    }
}
