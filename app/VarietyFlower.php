<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VarietyFlower extends Model
{
    protected $fillable = [
        'name',
        'type',
        'id_user', 
        'update_user'
    ];

    public function variety()
    {
        return $this->belongsTo('App\Variety', 'type');
    }
}
