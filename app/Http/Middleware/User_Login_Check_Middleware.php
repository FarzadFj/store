<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class User_Login_Check_Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (isset($_SESSION['phoneNumber']) && isset($_SESSION['password']))
        {
            $someone = User::where('phoneNumber', $_SESSION['phoneNumber'])->where('password', $_SESSION['password'])->first();

            if(empty ($someone))
            {
                return redirect('login');
            }
        }

        // if(!Auth::check())
        // {
        //     return redirect('login');
        // }

        return $next($request);
    }
}
