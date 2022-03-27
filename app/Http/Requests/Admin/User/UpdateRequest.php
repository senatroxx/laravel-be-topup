<?php

namespace App\Http\Requests\Admin\User;

use App\Helpers\FormRequest;

class UpdateRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'username' => 'required|string|unique:users,username,' . $this->user->id,
            'phone_number' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ];
    }
}
