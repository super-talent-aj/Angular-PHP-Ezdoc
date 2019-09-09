<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['eoir28', 'eoir33bia', 'eoir42a', 'eoir42b', 'g-28', 'i-485', 'i-589', 'i-765', 'i-864', 'n-400', 'i-864a'])->default('i-589');
            $table->string('name');
            $table->string('description');
            $table->integer('page_count');
            $table->longText('template');
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
        Schema::drop('forms');
    }
}
