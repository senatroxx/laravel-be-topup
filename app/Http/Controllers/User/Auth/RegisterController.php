<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Models\EmailVerification;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        $attributes = $request->validated();

        EmailVerification::where('type', 'REGISTER')->where('email', $attributes['email'])->delete();

        $attributes['email_verified_at'] = now();
        $attributes['password'] = bcrypt($attributes['password']);

        User::create($attributes);

        return Response::status('success')
            ->message("Register Successfully")
            ->result();
    }
}
