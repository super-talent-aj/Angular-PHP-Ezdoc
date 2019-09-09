<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
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
use App\Models\Lawfirm;

class Client extends Model
{
  use SoftDeletes;

  protected $table = 'clients';
  protected $dates = ['deleted_at'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function lawfirm()
  {
    return $this->belongsTo(Lawfirm::class);
  }

  public function docs()
  {
    return $this->hasMany(Doc::class, 'client_id');
  }

  public function backgroundAddresses()
  {
    return $this->hasMany(BackgroundAddress::class, 'client_id');
  }

  public function backgroundEmploys()
  {
    return $this->hasMany(BackgroundEmploy::class, 'client_id');
  }

  public function backgroundSchools()
  {
    return $this->hasMany(BackgroundSchool::class, 'client_id');
  }

  public function backgroundFamilies()
  {
    return $this->hasMany(BackgroundFamily::class, 'client_id');
  }

  public function clientApplication()
  {
    return $this->hasOne(ClientApplication::class, 'client_id');
  }

  public function clientPreparer()
  {
    return $this->hasOne(ClientPreparer::class, 'client_id');
  }

  public function clientProfile()
  {
    return $this->hasOne(ClientProfile::class, 'client_id');
  }

  public function clientRelationship()
  {
    return $this->hasMany(ClientRelationship::class, 'client_id');
  }

  public function clientSignature()
  {
    return $this->hasOne(ClientSignature::class, 'client_id');
  }

}
