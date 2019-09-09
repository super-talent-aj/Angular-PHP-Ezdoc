<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Doc;

class Form extends Model
{
  use SoftDeletes;

  protected $table = 'forms';
  protected $dates = ['deleted_at'];

  protected $fillable = [
    'name', 'description', 'template',
  ];

  public function docs()
  {
    return $this->hasMany(Doc::class, 'form_id');
  }
}
