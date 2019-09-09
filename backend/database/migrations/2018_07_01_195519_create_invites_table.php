<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('invites', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('lawfirm_id')->unsigned();
      $table->foreign('lawfirm_id')->references('id')->on('lawfirms')->onDelete('cascade');
      $table->string('email');
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
    Schema::drop('invites');
  }
}
