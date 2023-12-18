<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DaeRequest extends FormRequest
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
            'destination_country'   => 'required',
            'num_dae'               => 'required|unique:daes,num_dae',
            'id_farm'               => 'required',
            'date'                  => 'required',
            'arrival_date'          => 'required',
        ];
    }
}
