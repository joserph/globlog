<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WeightDistribution extends Model
{
    protected $fillable = [
        'report_w',
        'large',
        'width',
        'high',
        'average',
        'observation',
        'id_distribution',
        'id_flight',
        'id_user', 
        'update_user'
    ];

    public function packing()
    {
        return $this->belongsTo('App\Packing', 'observation');
    }
}
