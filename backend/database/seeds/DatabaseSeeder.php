<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\Models\Client;
use App\Models\Form;
use App\Models\Doc;
use App\Models\BackgroundFamily;
use App\Models\BackgroundEmploy;
use App\Models\BackgroundAddress;
use App\Models\BackgroundSchool;
use App\Models\ClientApplication;
use App\Models\ClientProfile;
use App\Models\ClientPreparer;
use App\Models\ClientRelationship;
use App\Models\ClientSignature;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Data seeding started.');

    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    Model::unguard();

    $this->call(LawfirmsTableSeeder::class);
    $this->call(UsersTableSeeder::class);
    $this->call(ClientsTableSeeder::class);
    $this->call(ClientProfilesTableSeeder::class);
    $this->call(ClientRelationshipsTableSeeder::class);
    $this->call(ClientSignaturesTableSeeder::class);
    $this->call(ClientPreparersTableSeeder::class);
    $this->call(ClientApplicationsTableSeeder::class);
    $this->call(BackgroundAddressesTableSeeder::class);
    $this->call(BackgroundSchoolsTableSeeder::class);
    $this->call(BackgroundEmploysTableSeeder::class);
    $this->call(BackgroundFamiliesTableSeeder::class);
    $this->call(FormsTableSeeder::class);
    $this->call(DocsTableSeeder::class);
    $this->call(InvitesTableSeeder::class);
  }
}

class UsersTableSeeder extends Seeder
{
  public function run()
  {
    App\User::truncate();
    factory(App\User::class)->create([
      'email' => 'superadmin@gmail.com',
      'password' => bcrypt('123456'),
      'status' => 'approved',
    ]);
    factory(App\User::class)->create([
      'email' => 'admin@gmail.com',
      'password' => bcrypt('123456'),
      'status' => 'approved',
    ]);
    factory(App\User::class)->create([
      'email' => 'paralegal@gmail.com',
      'password' => bcrypt('123456'),
      'status' => 'approved',
    ]);
    factory(App\User::class)->create([
      'email' => 'attorney@gmail.com',
      'password' => bcrypt('123456'),
      'status' => 'approved',
    ]);
    $users = factory(App\User::class, 15)->create();

    /**
     * Seeding roles table
     */
    Bican\Roles\Models\Role::truncate();
    DB::table('role_user')->truncate();
    $superAdminRole = Bican\Roles\Models\Role::create([
      'name' => 'Super Admin',
      'slug' => 'superadmin'
    ]);
    $adminRole = Bican\Roles\Models\Role::create([
      'name' => 'Admin',
      'slug' => 'admin'
    ]);
    $paralegalRole = Bican\Roles\Models\Role::create([
      'name' => 'Paralegal',
      'slug' => 'paralegal'
    ]);
    $attorneyRole = Bican\Roles\Models\Role::create([
      'name' => 'Attorney',
      'slug' => 'attorney'
    ]);


    App\User::whereEmail('superadmin@gmail.com')->get()->map(function ($user) use ($superAdminRole) {
      $user->attachRole($superAdminRole);
    });
    App\User::whereEmail('admin@gmail.com')->get()->map(function ($user) use ($adminRole) {
      $user->attachRole($adminRole);
    });
    App\User::whereEmail('paralegal@gmail.com')->get()->map(function ($user) use ($paralegalRole) {
      $user->attachRole($paralegalRole);
    });
    App\User::whereEmail('attorney@gmail.com')->get()->map(function ($user) use ($attorneyRole) {
      $user->attachRole($attorneyRole);
    });

    // profiles
    $faker = Faker::create();

    App\Models\Profile::truncate();
    $users = App\User::all();
    $users->each(function ($user) use ($faker) {
      $user->profile()->save(
        factory(App\Models\Profile::class)->create()
      );
    });
  }
}

class ClientsTableSeeder extends Seeder
{
  public function run()
  {
    Client::truncate();
    $users = App\User::all();
    $faker = Faker::create();
    $users->each(function ($user) use ($faker) {
      $user->clients()->save(
        factory(App\Models\Client::class)->create()
      );
    });

    $clients = Client::all();
    $clients->each(function ($client) {
      $client->lawfirm_id = $client->user->profile->lawfirm->id;
      $client->save();
    });
  }
}

class ClientProfilesTableSeeder extends Seeder
{
  public function run()
  {
    ClientProfile::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->clientProfile()->save(
        factory(App\Models\ClientProfile::class)->create()
      );
    });
  }
}

class ClientRelationshipsTableSeeder extends Seeder
{
  public function run()
  {
    ClientRelationship::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->clientRelationship()->save(
        factory(App\Models\ClientRelationship::class)->create()
      );
    });
  }
}

class ClientSignaturesTableSeeder extends Seeder
{
  public function run()
  {
    ClientSignature::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->clientSignature()->save(
        factory(App\Models\ClientSignature::class)->create()
      );
    });
  }
}

class ClientPreparersTableSeeder extends Seeder
{
  public function run()
  {
    ClientPreparer::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->clientPreparer()->save(
        factory(App\Models\ClientPreparer::class)->create()
      );
    });
  }
}

class ClientApplicationsTableSeeder extends Seeder
{
  public function run()
  {
    ClientApplication::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->ClientApplication()->save(
        factory(App\Models\ClientApplication::class)->create()
      );
    });
  }
}

class BackgroundAddressesTableSeeder extends Seeder
{
  public function run()
  {
    BackgroundAddress::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->backgroundAddresses()->save(
        factory(App\Models\BackgroundAddress::class)->create()
      );
    });
  }
}


class BackgroundSchoolsTableSeeder extends Seeder
{
  public function run()
  {
    BackgroundSchool::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->backgroundSchools()->save(
        factory(App\Models\BackgroundSchool::class)->create()
      );
    });
  }
}

class BackgroundEmploysTableSeeder extends Seeder
{
  public function run()
  {
    BackgroundEmploy::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->backgroundEmploys()->save(
        factory(App\Models\BackgroundEmploy::class)->create()
      );
    });
  }
}

class BackgroundFamiliesTableSeeder extends Seeder
{
  public function run()
  {
    BackgroundFamily::truncate();
    $clients = Client::all();
    $faker = Faker::create();
    $clients->each(function ($client) use ($faker) {
      $client->backgroundFamilies()->save(
        factory(App\Models\BackgroundFamily::class)->create()
      );
    });
  }
}

class FormsTableSeeder extends Seeder
{
  public function run()
  {
    Form::truncate();

    $data = [
      ['id' => 1, 'type' => 'i-589'],
      ['id' => 2, 'type' => 'eoir28'],
      ['id' => 3, 'type' => 'eoir33bia'],
      ['id' => 4, 'type' => 'eoir42a'],
      ['id' => 5, 'type' => 'eoir42b'],
      ['id' => 6, 'type' => 'g-28'],
      ['id' => 7, 'type' => 'i-485'],
      ['id' => 8, 'type' => 'i-765'],
      ['id' => 9, 'type' => 'i-864'],
      ['id' => 10, 'type' => 'n-400'],
      ['id' => 11, 'type' => 'i-864a'],
    ];

    foreach ($data as $row) {
      Form::create($row);
    }
  }
}

class DocsTableSeeder extends Seeder
{
  public function run()
  {
    Doc::truncate();
    $clients = Client::all();
    $clients->each(function ($client) {
      // add i-589 form to each client
      $profile = App\Models\Profile::where('lawfirm_id', $client->lawfirm_id)->get()->random();
      Doc::create([
        'client_id' => $client->id, 
        'form_id' => 1,
        'user_id' => $profile->user_id,
        'approved' => true,
      ]);
    });

    for ($i = 0; $i < 50; $i++) {
      $client = App\Models\Client::all()->random();
      $client_id = $client->id;
      $profile = App\Models\Profile::where('lawfirm_id', $client->lawfirm_id)->get()->random();

      $doc = [
        'client_id' => App\Models\Client::all()->random()->id,
        'form_id' => App\Models\Form::all()->random()->id,
        'user_id' => $profile->user_id,
        'approved' => true
      ];
      // Disallow duplicated doc
      $count = Doc::where([
        'client_id' => $doc['client_id'],
        'form_id' => $doc['form_id'],
      ])->count();
      if ($count == 0) {
        Doc::create($doc);
      }
    }
  }
}

class LawfirmsTableSeeder extends Seeder
{
  public function run()
  {
    App\Models\Lawfirm::truncate();
    factory(App\Models\Lawfirm::class, 15)->create();
  }
}

class InvitesTableSeeder extends Seeder
{
  public function run()
  {
    App\Models\Invite::truncate();
    factory(App\Models\Invite::class, 20)->create();
  }
}