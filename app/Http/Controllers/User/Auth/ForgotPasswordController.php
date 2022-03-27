<?php

namespace App\Http\Controllers\User\Auth;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\ForgotPasswordRequest;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        $credentials = $request->validated();

        EmailVerification::where('type', 'FORGOT_PASSWORD')->where('email', $credentials['email'])->delete();

        $user = User::where('email', $credentials['email'])->first();
        $user->password = bcrypt($credentials['password']);
        $user->save();

        return Response::status('success')
            ->message('Successfuly reset password.')
            ->result();
    }
}
