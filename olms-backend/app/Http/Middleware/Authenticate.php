<?php

namespace App\Http\Middleware;

use App\Exceptions\RequestException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null: route('login');
    // }

    // protected function unauthenticated($request, array $guards)
    // {
    //     if($request->expectsJson())
    //         throw new RequestException( json_encode('unauthenticated'),null,401);
    //     else
    //     return route('login');
    // }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function unauthenticated($request, array $guards)
    {

        throw new RequestException( json_encode('unauthenticated'),null,401);
    }
}
