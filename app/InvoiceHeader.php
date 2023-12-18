<?php

namespace App;
use Illuminate\Support\Arr;

use Illuminate\Database\Eloquent\Model;

class InvoiceHeader extends Model
{
    protected $fillable = [
        'id_company', // Mi empresa
        'id_load', // Carga
        'id_logistics_company', // Empresa de logistica
        'bl', 
        'carrier', 
        'invoice',
        'date',
        'total_bunches',
        'total_fulls',
        'total_pieces',
        'total_stems',
        'total',
        'id_user',
        'update_user',
        'coordination'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function userupdate()
    {
        return $this->belongsTo('App\User', 'update_user');
    }

    public static function groupEqualsMasterInvoice($invoiceItemsAll, $code)
    {
        foreach($invoiceItemsAll as $item)
        {
            // Buscamos los valores duplicados
            $dupliHawb = MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->count('hawb');
            // Validamos si hay valores duplicados, para agrupar
            
            if($dupliHawb > 1)
            {
                $fulls = ['fulls' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('fulls')];
                $pieces = ['pieces' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('pieces')];
                $name = ['name' => $item->name];
                $variety = ['variety' => $item->variety->name];
                $scientific = ['scientific_name' => $item->variety->scientific_name];
                $hawb = ['hawb' => $item->hawb];
                $stems = ['stems' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('stems')];
                $bunches = ['bunches' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('bunches')];
                $price = ['price' => $item->price];
                $total = ['total' => MasterInvoiceItem::where('id_load', '=', $code)->where('hawb', '=', $item->hawb)->where('variety_id', '=', $item->variety_id)->sum('total')];
                $client = ['client' => $item->client_confirm->name];
                // Para Facturas Fincas
                $address_farm = ['address_farm' => $item->address];
                $phone_farm = ['phone_farm' => $item->phone];
                $city_farm = ['city_farm' => $item->city];
                $address_client = ['address_client' => $item->client_confirm->address];
                $city_client = ['city_client' => $item->client_confirm->city];
                $state_client = ['state_client' => $item->client_confirm->state];
                $country_client = ['country_client' => $item->client_confirm->country];
                $phone_client = ['phone_client' => $item->client_confirm->phone];
                $carrier = ['carrier' => $item->invoiceh->carrier];
            }else{
                $fulls = ['fulls' => $item->fulls];
                $pieces = ['pieces' => $item->pieces];
                $name = ['name' => $item->name];
                $variety = ['variety' => $item->variety->name];
                $scientific = ['scientific_name' => $item->variety->scientific_name];
                $hawb = ['hawb' => $item->hawb];
                $stems = ['stems' => $item->stems];
                $bunches = ['bunches' => $item->bunches];
                $price = ['price' => $item->price];
                $total = ['total' => $item->total];
                $client = ['client' => $item->client_confirm->name];
                // Para Facturas Fincas
                $address_farm = ['address_farm' => $item->address];
                $phone_farm = ['phone_farm' => $item->phone];
                $city_farm = ['city_farm' => $item->city];
                $address_client = ['address_client' => $item->client_confirm->address];
                $city_client = ['city_client' => $item->client_confirm->city];
                $state_client = ['state_client' => $item->client_confirm->state];
                $country_client = ['country_client' => $item->client_confirm->country];
                $phone_client = ['phone_client' => $item->client_confirm->phone];
                $carrier = ['carrier' => $item->invoiceh->carrier];
            }
            $invoiceItemsArray[] = Arr::collapse([$carrier, $phone_client, $country_client, $state_client, $city_client, $address_client, $city_farm, $phone_farm, $address_farm, $fulls, $pieces, $name, $variety, $scientific, $hawb, $stems, $bunches, $price, $total, $client]);
        }

        return collect(array_unique($invoiceItemsArray, SORT_REGULAR));
    }

}
