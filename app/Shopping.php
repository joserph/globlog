<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    protected $fillable = [
        'quantity',
        'type',
        'id_variety',
        'size',
        'bunch',
        'stem_bunch',
        'price_stem',
        'price',
        'total_stem',
        'id_farm',
        'invoice',
        'id_load_flight',
        'distribution',
        'buyer',
        'cod_id_box',
        'id_user', 
        'update_user'
    ];
}
