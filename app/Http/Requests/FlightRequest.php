<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $awb = $this->route()->parameter('flight');

        if($awb){
            return [
                'awb'                   => 'required|max:13|unique:flights,awb,' . $awb,
                'carrier'               => 'required',
                'date'                  => 'required',
                'arrival_date'          => 'required',
                'id_user'               => '',
                'update_user'           => 'required',
                'code'                  => 'nullable',
                'brand'                 => 'nullable',
                'type_awb'              => 'required',
                'status'                => 'required',
                'origin_city'           => 'required',
                'origin_country'        => 'required',
                'destination_city'      => 'required',
                'destination_country'   => 'required',
            ];
        }else{
            return [
                'awb'                   => 'required|unique:flights,awb|max:13',
                'carrier'               => 'required',
                'date'                  => 'required',
                'arrival_date'          => 'required',
                'id_user'               => '',
                'update_user'           => 'required',
                'code'                  => 'nullable',
                'brand'                 => 'nullable',
                'type_awb'              => 'required',
                'status'                => 'required',
                'origin_city'           => 'required',
                'origin_country'        => 'required',
                'destination_city'      => 'required',
                'destination_country'   => 'required',
            ];
        }
        
    }
}
