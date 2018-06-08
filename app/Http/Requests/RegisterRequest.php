<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'max:16',
                'min:3',
                'unique:users',
                'regex:/^[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}$/'
            ],
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => "Username may only contain alphanumeric characters or single hyphens, and cannot begin or end with a hyphen",
            'name.unique' => "Username :name has been registered",
            'email.unique' => "Email :email has been registered",
        ];
    }
}
