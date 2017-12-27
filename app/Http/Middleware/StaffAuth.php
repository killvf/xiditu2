<?php

namespace App\Http\Middleware;

use Closure;

class StaffAuth
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
        if (empty($request->session()->get('staff'))) {
            return redirect()->route('staff.login');
        }

        return $next($request);
    }
}
