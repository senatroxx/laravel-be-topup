<?php

namespace App\Http\Middleware;

use App\Helpers\Response;
use Closure;
use Illuminate\Http\Request;

class VerifyDigiflazzCallback
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $secret = config('digiflazz.secret');
        $signature = hash_hmac('sha1', $request->getContent(), $secret);

        if ($request->header('X-Hub-Signature') != 'sha1=' . $signature) {
            return Response::status('failed')->code(401)
                ->message('You have attempeted to send a request for which you are not authorized.')
                ->result();
        }

        return $next($request);
    }
}
