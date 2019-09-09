<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('profiles', function (Blueprint $table) {
      $table->increments('id');
      $table->string('first_name');
      $table->string('middle_name');
      $table->string('last_name');
      $table->string('telephone_number');
      $table->string('mobile_number');
      $table->string('fax_number');
      $table->string('street');
      $table->boolean('apartment')->default(0);
      $table->boolean('suite')->default(0);
      $table->boolean('floor')->default(0);
      $table->string('apt_number');
      $table->string('city');
      $table->string('state');
      $table->string('zip_code');
      $table->string('province');
      $table->string('country');
      $table->string('uscis_account_number');
      $table->date('accereditation_expires_date');
      $table->boolean('is_attorney')->default(0);
      $table->string('licensing_authority');
      $table->string('bar_number');
      $table->boolean('is_subject_to_any')->default(0);
      $table->text('subject_explaination');
      $table->string('preparer_signature');
      $table->date('lawfirm_permanent_resident');
      $table->longText('avatar');
      $table->integer('user_id')->unsigned();
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->integer('lawfirm_id')->unsigned();
      $table->foreign('lawfirm_id')->references('id')->on('lawfirms')->onDelete('cascade');
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
    Schema::drop('profiles');
  }
}
