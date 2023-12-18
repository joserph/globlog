<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marketer extends Model
{
    protected $fillable = [
        'name',
        'clients',
        'id_user',
        'update_user'
    ];
}
