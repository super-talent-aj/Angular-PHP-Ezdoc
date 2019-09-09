<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Client;

class ClientSignature extends Model
{
    use SoftDeletes;

    protected $table = 'client_signatures';
    protected $dates = ['deleted_at'];

    public function client(){
      return $this->belongsTo(Client::class);
    }
}
