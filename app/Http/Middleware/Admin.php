<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isAdmin = Auth::user()->only(['role_id'])["role_id"] === 1;
        try {
            if ($isAdmin) {
                return $next($request);
            } else {
                throw new \Exception();
            }
        } catch (\Throwable $ex) {
            throw new Exception($ex->getMessage() . "You are not admin", 301);
        }

    }
}
