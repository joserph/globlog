<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class weightDistributionRequest extends FormRequest
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
            'report_w'      => 'required|numeric',
            'large'         => 'required|numeric',
            'width'         => 'required|numeric',
            'high'          => 'required|numeric',
            'observation'   => 'required'
        ];
    }
}
