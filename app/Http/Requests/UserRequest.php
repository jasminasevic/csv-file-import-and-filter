<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'role_id' => 'required|regex:/^[1-2]$/'
        ];
    }

    public function messages(){
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.string' => 'Invalid email',
            'email.email' => 'Wrong email format',
            'email.unique' => 'User with this email already exists',
            'password.required' => 'Password is required',
            'password.string' => 'Invalid password',
            'password.confirmed' => 'Unconfirmed password',
            'password.min' => 'Password should have minimum 6 characters',
            'role_id.required' => 'Role is required',
            'role_id.regex' => 'Invalid role'
        ];
    }
}
