<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('docs', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('client_id')->unsigned();
        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        $table->integer('form_id')->unsigned();
        $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->longText('data');
        $table->boolean('approved')->default(false);
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
      Schema::drop('docs');
    }
}
