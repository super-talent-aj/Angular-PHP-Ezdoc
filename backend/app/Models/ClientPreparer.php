<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Client;

class ClientPreparer extends Model
{
    use SoftDeletes;

    protected $table = 'client_prepareres';
    protected $dates = ['deleted_at'];

    public function client(){
      return $this->belongsTo(Client::class);
    }
}
