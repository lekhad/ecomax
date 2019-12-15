<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Frontlogin
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
//        echo "test"; die;
//        echo Session::get('frontSession'); die;
        // The frontSession is started in the UserController.php under the Login Function and register Function
        if(empty(Session::has('frontSession'))){
            return redirect('/login-register');
        }
        return $next($request);
    }
}
