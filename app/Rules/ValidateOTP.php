<?php

namespace App\Rules;

use App\Models\EmailVerification;
use Illuminate\Contracts\Validation\Rule;

class ValidateOTP implements Rule
{
    private $email;
    private $type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $email, string $type)
    {
        $this->email = $email;
        $this->type = $type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $email = request()->input($this->email);
        $correctOtp = EmailVerification::where('type', $this->type)->where('email', $email)->latest()->first();
        if (!$correctOtp) {
            return false;
        }
        return (int) $correctOtp->otp == $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Kode OTP salah';
    }
}
