<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    protected $fillable = [
        'shipment',
        'bl',
        'carrier',
        'date',
        'arrival_date',
        'id_user',
        'update_user',
        'code_deep',
        'brand_deep',
        'code_door',
        'brand_door',
        'booking',
        'id_logistic_company',
        'container_number',
        'seal_bottle',
        'seal_cable',
        'seal_sticker',
        'id_qa',
        'floor',
        'num_pallets'
    ];

    public function invoiceheader()
    {
        return $this->belongsTo('App\InvoiceHeader', 'id_load');
    }

    public function logistic_company()
    {
        return $this->belongsTo('App\LogisticCompany', 'id_logistic_company');
    }

    public function qacompany()
    {
        return $this->belongsTo('App\QACompany', 'id_qa');
    }
}
