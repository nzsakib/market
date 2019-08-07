<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class CustomerMiddleware
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
        if ($request->user()->type != User::TYPE_CUSTOMER) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
