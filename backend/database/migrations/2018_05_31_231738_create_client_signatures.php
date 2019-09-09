<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientSignatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_signatures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('complete_name');
            $table->string('native_name_alphabet');
            $table->boolean('relation_assist_me');
            $table->string('assist_1_name')->nullable();
            $table->string('assist_1_relationship')->nullable();
            $table->string('assist_2_name')->nullable();
            $table->string('assist_2_relationship')->nullable();
            $table->boolean('other_assist_me');
            $table->boolean('application_counsel');
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
        Schema::drop('client_signatures');
    }
}
