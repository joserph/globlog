<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'client_id'     => 'required',
            'num_invoice'   => '',
            'count'         => '',
            'load_id'       => 'nullable',
            'flight_id'     => 'nullable',
            'date'          => 'required',
            'terms'         => 'required',
            'type'          => 'required',
            'load_type'     => 'required',
        ];
    }
}
