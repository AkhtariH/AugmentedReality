<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'username' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'type' => 'required'
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
            'username.required' => 'Username is required!',
            'username.unique' => 'The user with the entered username already exists!',
            'first_name.required' => 'First name is required!',
            'last_name.required' => 'Last name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'This is not a valid email adress!',
            'email.unique' => 'The user with the entered email adress already exists!',
            'type.required' => 'Account type is required!'
        ];
    }
}
