<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QACompanyRequest extends FormRequest
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
            'name' => 'required',
            'owner' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            'email' => 'required',
            'id_user' => 'required',
            'update_user' => 'required',
        ];
    }
}
