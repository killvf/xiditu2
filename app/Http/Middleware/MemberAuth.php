<?php

namespace App\Http\Middleware;

use Closure;

class MemberAuth
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
        if (empty($request->session()->get('member'))) {
            return redirect()->route('member.login');
        }

        return $next($request);
    }
}
