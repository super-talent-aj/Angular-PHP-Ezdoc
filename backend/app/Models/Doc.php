<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doc extends Model
{
  use SoftDeletes;

  protected $table = 'docs';
  protected $dates = ['deleted_at'];

  public function client()
  {
    return $this->belongsTo(Client::class, 'client_id');
  }

  public function form()
  {
    return $this->belongsTo(Form::class, 'form_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
