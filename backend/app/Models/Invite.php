<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Lawfirm;

class Invite extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $table = 'invites';

  protected $fillable = [
    'email', 'lawfirm_id',
  ];

  public function lawfirm()
  {
    return $this->belongsTo(Lawfirm::class, 'lawfirm_id');
  }
}
