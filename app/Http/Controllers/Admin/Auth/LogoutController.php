<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\Response;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $user = auth('admin-api')->user()->token();
        $user->revoke();

        return Response::status('success')
            ->message("Successfuly Logout.")
            ->result();
    }
}
