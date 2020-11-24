<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\eyb_users;
class StudentMiddleware
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
       if(session('user_id')){
            // $log = session('user_id');
            // $student      = eyb_users::where('log',$log)->first();
            // if (!empty($student))
            // {
                return $next($request);
            // }else{
            //     return redirect()->route('login')->with('access_error','Unauthorized access page.');
            // }
        }
        else{
            return redirect()->route('login')->with('access_error','Unauthorized access page.');
        }
    }
}
