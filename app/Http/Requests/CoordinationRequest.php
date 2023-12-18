<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoordinationRequest extends FormRequest
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
            'hawb' => 'required|unique:coordinations,hawb',
            'pieces' => '',
            'hb' => 'required',
            'qb' => 'required', 
            'eb' => 'required', 
            'hb_r' => '',
            'qb_r' => '',
            'eb_r' => '',
            'missing' => '',
            'id_client' => 'required',
            'id_farm' => 'required',
            'id_load' => '',
            'variety_id' => 'required',
            'id_user' => 'required',
            'update_user' => 'required'
        ];
    }
}
