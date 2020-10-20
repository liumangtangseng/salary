<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        $staff_id = session()->get('staff_id');
        if(!isset($staff_id)|| $staff_id<0)
            return redirect('/login');
        return $next($request);
    }
}
