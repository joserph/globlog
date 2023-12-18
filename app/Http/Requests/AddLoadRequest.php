<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLoadRequest extends FormRequest
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
        return [
            //'shipment'  => 'required|numeric|unique:loads,shipment',
            'shipment'  => 'required|numeric',
            'bl'        => 'max:19|unique:loads,bl',
            'carrier'   => 'required',
            'date'      => 'required',
            'id_logistic_company' => 'required'
        ];
    }
}
