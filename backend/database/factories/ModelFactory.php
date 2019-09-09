<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
  return [
    'email' => $faker->safeEmail,
    'password' => bcrypt(str_random(10)),
    'remember_token' => str_random(10),
  ];
});

$factory->define(App\Models\Profile::class, function (Faker\Generator $faker) {
  return [
    'first_name' => $faker->firstName,
    'middle_name' => $faker->lastName,
    'last_name' => $faker->lastName,
    'telephone_number' => $faker->tollFreePhoneNumber,
    'mobile_number' => $faker->phoneNumber,
    'fax_number' => $faker->phoneNumber,
    'street' => $faker->streetAddress,
    'apartment' => random_int(0, 1),
    'suite' => random_int(0, 1),
    'floor' => random_int(0, 1),
    'apt_number' => $faker->buildingNumber,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'zip_code' => $faker->buildingNumber,
    'province' => $faker->state,
    'country' => $faker->country,
    'uscis_account_number' => $faker->creditCardNumber,
    'accereditation_expires_date' => $faker->date('Y-m-d'),
    'is_attorney' => random_int(0, 1),
    'licensing_authority' => $faker->company,
    'bar_number' => $faker->isbn13,
    'is_subject_to_any' => random_int(0, 1),
    'subject_explaination' => $faker->text(),
    'preparer_signature' => $faker->word(),
    'avatar' => '../../../../assets/common/img/avatar.png',
    'lawfirm_id' => App\Models\Lawfirm::all()->random()->id
  ];
});

$factory->define(App\Models\Client::class, function (Faker\Generator $faker) {
  return [
    'alien_reg_num' => $faker->creditCardNumber,
    'us_social_security_num' => $faker->bankAccountNumber,
    'USCIS_account_num' => $faker->bankAccountNumber,
    'first_name' => $faker->firstName,
    'middle_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'maiden_aliase_name' => $faker->titleMale,
    'residence_street_num' => $faker->streetName,
    'residence_apt_type' => $faker->randomElement(['apartment', 'suite', 'floor']),
    'residence_apt_num' => $faker->buildingNumber,
    'residence_city' => $faker->city,
    'residence_state' => $faker->stateAbbr,
    'residence_county' => $faker->cityPrefix,
    'residence_province' => $faker->state,
    'residence_postal_code' => $faker->postcode,
    'residence_country' => $faker->country,
    'residence_zip_code' => $faker->countryCode,
    'residence_telephone_num' => $faker->phoneNumber,
    'residence_mobile_num' => $faker->e164PhoneNumber,
    'residence_email_address' => $faker->email,
    'gender' => sprintf("%s", $faker->randomElement(['male', 'female'])),
    'marital_status' => sprintf("%s", $faker->randomElement(['single', 'married', 'divorced', 'widowed'])),
    'birth_date' => $faker->date('Y-m-d'),
    'birth_city' => $faker->city,
    'birth_country' => $faker->country,
  ];
});

$factory->define(App\Models\ClientProfile::class, function (Faker\Generator $faker) {
  return [
    'mailing_address_care' => $faker->address,
    'mailing_address_street_num' => $faker->streetName,
    'mailing_address_apt_type' => $faker->randomElement(['apartment', 'suite', 'floor']),
    'mailing_address_apt_num' => $faker->buildingNumber,
    'mailing_address_city' => $faker->city,
    'mailing_address_county' => $faker->cityPrefix,
    'mailing_address_province' => $faker->state,
    'mailing_address_postal_code' => $faker->postCode,
    'mailing_address_country' => $faker->country,
    'mailing_address_state' => $faker->stateAbbr,
    'mailing_address_zip_code' => $faker->countryCode,
    'mailing_address_telephone_num' => $faker->phoneNumber,
    'nationality_present' => $faker->country,
    'nationality_birth' => $faker->country,
    'race_ethnic_tribal_group' => $faker->country,
    'religion' => $faker->safeColorName,
    'immigration_court_proceeding' => sprintf("%s", $faker->randomElement(['never', 'now', 'past'])),
    'leave_country_date' => $faker->date('Y-m-d'),
    'i94_num' => $faker->creditCardNumber,
    'entry_1_date' => $faker->date('Y-m-d'),
    'entry_1_place' => $faker->country,
    'entry_1_status' => $faker->streetAddress,
    'entry_1_status_expires' => $faker->date('Y-m-d'),
    'entry_2_date' => $faker->date('Y-m-d'),
    'entry_2_place' => $faker->country,
    'entry_2_status' => $faker->streetAddress,
    'entry_3_date' => $faker->date('Y-m-d'),
    'entry_3_place' => $faker->country,
    'entry_3_status' => $faker->streetAddress,
    'passport_issued_country' => $faker->country,
    'passport_num' => $faker->bankAccountNumber,
    'passport_travel_num' => $faker->bankAccountNumber,
    'passport_expiration_date' => $faker->date('Y-m-d'),
    'language_native' => $faker->country,
    'language_english_fluent' => true,
    'language_other' => $faker->country,
    'lawfirm_permanent_resident' => $faker->date('Y-m-d'),
    'residence_current_address_from' => $faker->date('Y-m-d'),
    'residence_current_address_to' => $faker->date('Y-m-d'),
    'date_last_entry' => $faker->date('Y-m-d'),
    'place_last_entry' => $faker->streetAddress,
  ];
});

$factory->define(App\Models\ClientRelationship::class, function (Faker\Generator $faker) {
  return [

    'relation_type' => sprintf("%s", $faker->randomElement(['spouse', 'child1', 'child2', 'child3'])),
    'alien_reg_num' => $faker->creditCardNumber,
    'passport_num' => $faker->bankAccountNumber,
    'us_social_security_num' => $faker->bankAccountNumber,
    'first_name' => $faker->firstName,
    'middle_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'maiden_aliase_name' => $faker->titleMale,
    'birth_date' => $faker->date('Y-m-d'),
    'birth_city_country' => $faker->country,
    'nationality' => $faker->country,
    'race_ethnic_tribal_group' => $faker->country,
    'gender' => sprintf("%s", $faker->randomElement(['male', 'female'])),
    'us_person' => true,
    'location' => $faker->address,
    'entry_date' => $faker->date('Y-m-d'),
    'entry_place' => $faker->country,
    'i94_num' => $faker->creditCardNumber,
    'last_admitted_status' => $faker->streetAddress,
    'entry_status' => $faker->streetAddress,
    'entry_status_expires' => $faker->date('Y-m-d'),
    'immigration_court_proceeding' => true,
    'include_application' => true,
    'marriage_date' => $faker->date('Y-m-d'),
    'marriage_place' => $faker->country,
    'previous_arrival_date' => $faker->date('Y-m-d'),
    'marital_status' => sprintf("%s", $faker->randomElement(['single', 'married', 'divorced', 'widowed'])),
  ];
});


$factory->define(App\Models\ClientSignature::class, function (Faker\Generator $faker) {
  return [
    'complete_name' => $faker->name,
    'native_name_alphabet' => $faker->name,
    'relation_assist_me' => true,
    'assist_1_name' => $faker->name,
    'assist_1_relationship' => sprintf("%s", $faker->randomElement(['spouse', 'child1', 'father', 'mother', 'sibling1'])),
    'assist_2_name' => $faker->name,
    'assist_2_relationship' => sprintf("%s", $faker->randomElement(['spouse', 'child1', 'father', 'mother', 'sibling1'])),
    'other_assist_me' => true,
    'application_counsel' => true
  ];
});


$factory->define(App\Models\ClientPreparer::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'state_bar_num' => $faker->bankAccountNumber,
    'USCIS_account_num' => $faker->bankAccountNumber,
    'G28' => true,
    'street_num' => $faker->streetName,
    'apt_num' => $faker->buildingNumber,
    'city' => $faker->city,
    'state' => $faker->streetAddress,
    'zip_code' => $faker->countryCode,
    'telephone_num' => $faker->phoneNumber
  ];
});

$factory->define(App\Models\ClientApplication::class, function (Faker\Generator $faker) {
  return [

    'asylum_by_race' => $faker->randomElement([true, false]),
    'asylum_by_religion' => $faker->randomElement([true, false]),
    'asylum_by_nationality' => $faker->randomElement([true, false]),
    'asylum_by_political' => $faker->randomElement([true, false]),
    'asylum_by_membership' => $faker->randomElement([true, false]),
    'asylum_by_torture' => $faker->randomElement([true, false]),
    'mistreatment_past_bool' => $faker->randomElement([true, false]),
    'mistreatment_past_text' => $faker->text,
    'mistreatment_return_bool' => $faker->randomElement([true, false]),
    'mistreatment_return_text' => $faker->text,
    'law_imprisoned_bool' => $faker->randomElement([true, false]),
    'law_imprisoned_text' => $faker->text,
    'associated_organization_bool' => $faker->randomElement([true, false]),
    'associated_organization_text' => $faker->text,
    'continue_organization_bool' => $faker->randomElement([true, false]),
    'continue_organization_text' => $faker->text,
    'torture_return_bool' => $faker->randomElement([true, false]),
    'torture_return_text' => $faker->text,
    'application_before_bool' => $faker->randomElement([true, false]),
    'application_before_text' => $faker->text,
    'travel_reside_bool' => $faker->randomElement([true, false]),
    'lawful_apply_other_bool' => $faker->randomElement([true, false]),
    'lawful_apply_other_text' => $faker->text,
    'cause_harm_bool' => $faker->randomElement([true, false]),
    'cause_harm_text' => $faker->text,
    'return_country_past_bool' => $faker->randomElement([true, false]),
    'return_country_past_text' => $faker->text,
    'apply_more_year_bool' => $faker->randomElement([true, false]),
    'apply_more_year_text' => $faker->text,
    'lawful_apply_US_bool' => $faker->randomElement([true, false]),
    'lawful_apply_US_text' => $faker->text
  ];
});


$factory->define(App\Models\BackgroundAddress::class, function (Faker\Generator $faker) {
  return [
    'address_type' => sprintf("%s", $faker->randomElement(['last', 'fear', 'other1'])),
    'street_num' => $faker->streetAddress,
    'city_town' => $faker->city,
    'department_province_state' => $faker->bankAccountNumber,
    'country' => $faker->country,
    'start_date' => $faker->date('Y-m-d'),
    'end_date' => $faker->date('Y-m-d')
  ];
});

$factory->define(App\Models\BackgroundSchool::class, function (Faker\Generator $faker) {
  return [
    'school_name' => $faker->streetName,
    'school_type' => $faker->company,
    'school_location' => $faker->address,
    'start_date' => $faker->date('Y-m-d'),
    'end_date' => $faker->date('Y-m-d')
  ];
});

$factory->define(App\Models\BackgroundEmploy::class, function (Faker\Generator $faker) {
  return [
    'employer_name' => $faker->company,
    'employ_occupation' => $faker->jobTitle,
    'start_date' => $faker->date('Y-m-d'),
    'end_date' => $faker->date('Y-m-d')
  ];
});

$factory->define(App\Models\BackgroundFamily::class, function (Faker\Generator $faker) {
  return [
    'family_type' => sprintf("%s", $faker->randomElement(['father', 'mother', 'sibling1'])),
    'family_name' => $faker->userName,
    'family_birth_city_country' => $faker->city,
    'deceased' => $faker->randomElement([true, false]),
    'location' => $faker->address,
  ];
});
$factory->define(App\Models\Doc::class, function (Faker\Generator $faker) {
  $client = App\Models\Client::all()->random();
  $client_id = $client->id;
  $profile = App\Models\Profile::where('lawfirm_id', $client->lawfirm_id)->random();

  return [
    'client_id' => $client_id,
    'form_id' => App\Models\Form::all()->random()->id,
    'user_id' => $profile->user_id,
  ];
});

$factory->define(App\Models\Lawfirm::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->company,
    'password' => base64_encode('123456'),
    'street' => $faker->streetAddress,
    'apartment' => random_int(0, 1),
    'suite' => random_int(0, 1),
    'floor' => random_int(0, 1),
    'apt_number' => $faker->word,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'zip_code' => $faker->buildingNumber,
    'province' => $faker->state,
    'postal_code' => $faker->postcode,
    'country' => $faker->country,
  ];
});


$factory->define(App\Models\Invite::class, function (Faker\Generator $faker) {
  return [
    'lawfirm_id' => App\Models\Lawfirm::all()->random()->id,
    'email' => $faker->email,
  ];
});