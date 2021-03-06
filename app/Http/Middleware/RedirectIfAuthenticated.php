<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::user();
            if ($user->type == User::TYPE_CUSTOMER) {
                return redirect()->route('customer.profile');
            } elseif ($user->type == User::TYPE_VENDOR) {
                return redirect()->route('vendor.profile');
            }
        }

        return $next($request);
    }
}
