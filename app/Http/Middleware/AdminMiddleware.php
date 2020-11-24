<?php

namespace App\Http\Middleware;

use App\eyb_users;
use Closure;
use Session;
class AdminMiddleware
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
        if(session('log_status')){
            // $log = session('log_status');
            // $admin      = eyb_users::where('log',$log)->first();
            // if (!empty($admin))
            // {
                return $next($request);
            // }else{
            //     return redirect()->route('backend')->with('error','Unauthorized access page.');
            // }
        }
        else{
            return redirect()->route('backend')->with('error','Unauthorized access page.');
        }
    }
}
