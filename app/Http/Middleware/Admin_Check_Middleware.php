<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;

class Admin_Check_Middleware
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
        // $admin = Admin::where('phoneNumber', $request->phoneNumber)->first();

        // if(empty ($admin))
        // {
        //     return redirect('/admin/login');
        // }

        if (isset($_SESSION['phoneNumber']) && isset($_SESSION['password']))
        {
            $someone = Admin::where('phoneNumber', $_SESSION['phoneNumber'])->where('password', $_SESSION['password'])->first();

            if(empty ($someone))
            {
                return redirect('admin/login');
            }
        }

        return $next($request);
    }
}
