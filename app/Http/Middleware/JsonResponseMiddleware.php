<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->expectsJson()) {
            if ($response->exception) {
                $exception = $response->exception;
                if ($exception instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'errors' => $exception->errors()
                    ], 422);
                }
            }
        }

        return $response;
    }
}
