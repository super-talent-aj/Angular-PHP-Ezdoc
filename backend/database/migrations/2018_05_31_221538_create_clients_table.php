<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alien_reg_num');
            $table->string('us_social_security_num');
            $table->string('USCIS_account_num');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('maiden_aliase_name');
            $table->string('residence_street_num');
            $table->enum('residence_apt_type', ['none', 'apartment', 'suite', 'floor'])->default('none');
            $table->string('residence_apt_num');
            $table->string('residence_city');
            $table->string('residence_state');
            $table->string('residence_county');
            $table->string('residence_province');
            $table->string('residence_postal_code');
            $table->string('residence_country');
            $table->string('residence_zip_code');
            $table->string('residence_telephone_num');
            $table->string('residence_mobile_num');
            $table->string('residence_email_address');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->default('single');
            $table->date('birth_date');
            $table->string('birth_city');
            $table->string('birth_country');
            $table->date('application_date');
            $table->date('additional_information_date');
            $table->string('additional_information_part');
            $table->string('additional_information_question');
            $table->text('additional_information_text');
            $table->longText('photo');
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
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
