<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use App\Models\Profile;
use App\Models\Client;
use App\Models\Doc;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasRoleAndPermissionContract
{
  use SoftDeletes;

  protected $dates = ['deleted_at'];

  use Authenticatable, CanResetPassword, HasRoleAndPermission;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password', 'status'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'remember_token',
  ];

  public function profile()
  {
    return $this->hasOne(Profile::class, 'user_id');
  }

  public function clients()
  {
    return $this->hasMany(Client::class, 'user_id');
  }

  public function docs()
  {
    return $this->hasMany(Doc::class, 'user_id');
  }
}
