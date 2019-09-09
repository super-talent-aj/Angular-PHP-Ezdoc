<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Notification extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'notifications';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
