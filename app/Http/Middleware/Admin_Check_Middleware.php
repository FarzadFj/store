<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        // if (isset($_SESSION['phoneNumber']) && isset($_SESSION['password']))
        // {
        //     $someone = Admin::where('phoneNumber', $_SESSION['phoneNumber'])->where('password', $_SESSION['password'])->first();

        //     if(empty ($someone))
        //     {
        //         return redirect('admin/login');
        //     }
        // }
        
        // ravesh behtar::
        
        /*
        $someone_phoneNumber = $request->user()->phoneNumber;
        $someone_password = $request->user()->password;

        $someone = Admin::where('phoneNumber', $someone_phoneNumber)->where('password', $someone_password)->first();

        if(empty ($someone))
        {
            // return redirect('admin/login');
            return response()->json([
                'massege' => 'phoneNumber or password is wrong',
                'massege 2' => $someone_phoneNumber,
                'massege 3' => $someone_password
            ], 400);
        }
        */


        return $next($request);
    }
}
