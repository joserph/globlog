<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hawb extends Model
{
    protected $fillable = [
        'hawb',
        'hawb_format',
        'id_user',
        'update_user',
    ];
}
