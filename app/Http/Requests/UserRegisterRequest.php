<?php

namespace Um\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'username' => ['required', 'string', 'min:2', 'max:255'],//, 'unique:users'  This rules needs to assign better logic when update a user info.
            'email' => ['required', 'string', 'email', 'max:255'],//, 'unique:users'
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * Customize message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'username.required' => 'Username is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ];
    }
}
