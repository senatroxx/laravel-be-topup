<?php

namespace App\Http\Middleware;

use App\Helpers\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            abort(
                Response::status('failed')->code(401)
                    ->message('You have attempeted to send a request for which you are not authorized.')
                    ->result()
            );
        }
    }
}
