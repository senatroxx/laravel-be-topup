<?php

namespace App\Http\Middleware;

use App\Helpers\Response;
use Closure;

class CheckForAnyScope
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$scopes
     * @return \App\Helper\Response
     *
     */
    public function handle($request, $next, ...$scopes)
    {
        if (!$request->user() || !$request->user()->token()) {
            return Response::status('failed')->code(403)
                ->message('You have attempeted to send a request for which you are not authenticated.')
                ->result();
        }

        foreach ($scopes as $scope) {
            if ($request->user()->tokenCan($scope)) {
                return $next($request);
            }
        }

        return Response::status('failed')->code(401)
            ->message('You have attempeted to send a request for which you are not authorized.')
            ->result();
    }
}
