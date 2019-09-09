<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLawfirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lawfirms', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('password');
          $table->string('country');
          $table->string('state');
          $table->string('province');
          $table->string('city');
          $table->string('street');
          $table->boolean('apartment')->default(0);
          $table->boolean('suite')->default(0);
          $table->boolean('floor')->default(0);
          $table->string('apt_number');
          $table->string('zip_code');
          $table->string('postal_code');
          $table->timestamps(); // created_at, updated_at
          $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lawfirms');
    }
}
