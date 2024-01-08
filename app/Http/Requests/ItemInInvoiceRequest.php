<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemInInvoiceRequest extends FormRequest
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
            'description_id'=> 'required',
            'invoice_id'    => '',
            'pieces'        => 'required',
            'quantity'      => 'required',
            'rate'          => 'required',
            'amount'        => 'required',
        ];
    }
}
