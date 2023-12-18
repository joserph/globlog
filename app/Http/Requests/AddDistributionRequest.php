<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDistributionRequest extends FormRequest
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
        //dd($this->duplicate);
        if($this->duplicate == 'on')
        {
            //dd('duplicada');
            $hawb = '';
        }else{
            //dd('null');
            $hawb = 'unique:distributions,hawb';
        }
        //dd(str_replace("'", '', $hawb));
        return [
            'hawb' => $hawb,
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
            'id_flight' => 'required',
            'variety_id' => 'required',
            'id_user' => 'required',
            'update_user' => 'required',
            'observation' => ''
        ];
    }
}
