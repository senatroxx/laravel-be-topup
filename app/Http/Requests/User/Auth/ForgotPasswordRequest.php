<?php

namespace App\Http\Requests\User\Auth;

use App\Helpers\FormRequest;
use App\Rules\ValidateOTP;

class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|confirmed|min:8',
            'otp' => ['required', 'numeric', new ValidateOTP('email', 'FORGOT_PASSWORD')],
        ];
    }
}
