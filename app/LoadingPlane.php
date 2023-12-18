<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoadingPlane extends Model
{
    protected $fillable = [
        'space',
        'hb',
        'qb',
        'eb',
        'floor',
        'id_client',
        'id_farm',
        'id_load',
        'id_user',
        'update_user'
    ];
}
