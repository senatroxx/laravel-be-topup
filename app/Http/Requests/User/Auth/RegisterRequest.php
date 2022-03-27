<?php

namespace App\Http\Requests\User\Auth;

use App\Helpers\FormRequest;
use App\Rules\ValidateOTP;

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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'phone_number' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
            'otp' => ['required', 'numeric', new ValidateOTP('email', 'REGISTER')],
        ];
    }
}
