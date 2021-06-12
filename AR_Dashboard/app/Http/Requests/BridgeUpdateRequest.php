<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BridgeUpdateRequest extends FormRequest
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
            'adress' => 'required',
            'supervisor' => 'required',
            'bridgeHash' => 'required'
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'adress.required' => 'Adress is required!',
            'supervisor.required' => 'Supervisor is required!',
            'bridgeHash.required' => 'The bridge hash is required!',
        ];
    }
}
