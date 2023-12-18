<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'type',
        'id_type',
        'color',
        'label',
        'id_user',
        'update_user',
        'load_type'
    ];
}
