<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
            if($guard == 'employer') {
                if ($request->path() == 'employer/login'){
                    return redirect('/company/mypage');
                }
            }
            if($guard == '') {
                if ($request->url() == 'members/login'){
                    return redirect('/mypage/index');
                }
            }
        }

        return $next($request);
    }
}
