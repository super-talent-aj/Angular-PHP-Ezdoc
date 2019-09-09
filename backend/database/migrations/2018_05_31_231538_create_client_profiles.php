<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('mailing_address_care');
            $table->string('mailing_address_street_num');
            $table->enum('mailing_address_apt_type', ['none', 'apartment', 'suite', 'floor'])->default('none');
            $table->string('mailing_address_apt_num');
            $table->string('mailing_address_city');
            $table->string('mailing_address_county');
            $table->string('mailing_address_province');
            $table->string('mailing_address_postal_code');
            $table->string('mailing_address_country');
            $table->string('mailing_address_state');
            $table->string('mailing_address_zip_code');
            $table->string('mailing_address_telephone_num');
            $table->string('nationality_present');
            $table->string('nationality_birth');
            $table->string('race_ethnic_tribal_group');
            $table->string('religion');
            $table->enum('immigration_court_proceeding', ['never', 'now', 'past'])->nullable();
            $table->date('leave_country_date');
            $table->string('i94_num');
            $table->date('entry_1_date');
            $table->string('entry_1_place');
            $table->string('entry_1_status');
            $table->date('entry_1_status_expires');
            $table->date('entry_2_date');
            $table->string('entry_2_place');
            $table->string('entry_2_status');
            $table->date('entry_3_date');
            $table->string('entry_3_place');
            $table->string('entry_3_status');
            $table->string('passport_issued_country');
            $table->string('passport_num');
            $table->string('passport_travel_num');
            $table->date('passport_expiration_date');
            $table->string('language_native');
            $table->boolean('language_english_fluent');
            $table->string('language_other');
            $table->date('lawfirm_permanent_resident');
            $table->date('residence_current_address_from');
            $table->date('residence_current_address_to');
            $table->date('date_last_entry');
            $table->string('place_last_entry');
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
        Schema::drop('client_profiles');
    }
}
