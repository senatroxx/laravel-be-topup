<?php

namespace App\Http\Controllers\User\Auth;

use App\Events\SendMail;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\EmailVerificationRequest;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class EmailVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $attributes = $request->validated();

        $token = random_int(100000, 999999);

        $attributes['otp'] = $token;
        EmailVerification::create($attributes);

        Event::dispatch(new SendMail($attributes['email'], $token));

        return Response::status('success')
            ->message("Success send OTP to your Email. Please check your Email Message")
            ->result();
    }
}
