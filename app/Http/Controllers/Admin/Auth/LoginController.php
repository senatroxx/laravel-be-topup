<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = Admin::whereEmail($credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return Response::status('failed')->code(401)
                ->message('The Credentials are Incorrect.')
                ->result();
        }

        $token = $user->createToken($user->email . '-' . now(), ['admin']);
        $expires = now()->diffInSeconds($token->token->expires_at);

        return Response::status('success')->message('Successfuly login.')
            ->result([
                "token" => $token->accessToken,
                "expires_in" => $expires,
                "user" => new AdminResource($user),
            ]);
    }
}
