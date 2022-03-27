<?php

namespace App\Http\Requests\User\Auth;

use App\Helpers\FormRequest;

class EmailVerificationRequest extends FormRequest
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
        $emailRule = $this->type == 'REGISTER' ? 'unique:users,email' : 'exists:users,email';
        return [
            'email' => 'required|email|' . $emailRule,
            'type' => 'required|string',
        ];
    }
}
