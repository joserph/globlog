<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceHeaderRequest extends FormRequest
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
            'id_load'               => 'required',
            'bl'                    => 'required',
            'id_company'            => 'required',
            'id_logistics_company'  => 'required',
            'invoice'               => 'required|max:50|unique:invoice_headers,invoice',
            'date'                  => 'required'
        ];
    }
}
