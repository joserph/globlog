<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    protected $fillable = [
        'name',
        'ruc',
        'phone',
        'email',
        'id_user',
        'update_user'
    ];
}
