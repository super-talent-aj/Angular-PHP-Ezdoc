<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Profile;
use App\Models\Client;

class Lawfirm extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $table = 'lawfirms';

  public function profiles()
  {
    return $this->hasMany(Profile::class, 'lawfirm_id');
  }

  public function invites()
  {
    return $this->hasMany(Invite::class, 'lawfirm_id');
  }

  public function clients()
  {
    return $this->hasMany(Client::class, 'lawfirm_id');
  }
}
