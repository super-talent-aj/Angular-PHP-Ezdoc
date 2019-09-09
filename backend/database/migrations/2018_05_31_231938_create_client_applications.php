<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('asylum_by_race');
            $table->boolean('asylum_by_religion');
            $table->boolean('asylum_by_nationality');
            $table->boolean('asylum_by_political');
            $table->boolean('asylum_by_membership');
            $table->boolean('asylum_by_torture');
            $table->boolean('mistreatment_past_bool');
            $table->text('mistreatment_past_text');
            $table->boolean('mistreatment_return_bool');
            $table->text('mistreatment_return_text');
            $table->boolean('law_imprisoned_bool');
            $table->text('law_imprisoned_text');
            $table->boolean('associated_organization_bool');
            $table->text('associated_organization_text');
            $table->boolean('continue_organization_bool');
            $table->text('continue_organization_text');
            $table->boolean('torture_return_bool');
            $table->text('torture_return_text');
            $table->boolean('application_before_bool');
            $table->text('application_before_text');
            $table->boolean('travel_reside_bool');
            $table->boolean('lawful_apply_other_bool');
            $table->text('lawful_apply_other_text');
            $table->boolean('cause_harm_bool');
            $table->text('cause_harm_text');
            $table->boolean('return_country_past_bool');
            $table->text('return_country_past_text');
            $table->boolean('apply_more_year_bool');
            $table->text('apply_more_year_text');
            $table->boolean('lawful_apply_US_bool');
            $table->text('lawful_apply_US_text');
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
        Schema::drop('client_applications');
    }
}
