<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AdminResource;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login (Request $request)
    {
        $admin_data = $request->validate([
            'phoneNumber' => 'required|string',
            'password' => 'required|string'
        ]);

        $admin = Admin::where('phoneNumber', $admin_data['phoneNumber'])
            ->where('password', $admin_data['password'])
            ->first();

        if (empty($admin))
        {
            return response()->json([
                'message' => 'password or phoneNumber is wrong'
            ], 400);
        }

        return response()->json([
            'admin' => $admin,
            'token' => $admin->createToken('userToken')->plainTextToken,
            'token_type' => 'Bearer',
            'message' => 'Admin login successfully'
        ]);


        /*
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|numeric',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $admin = Admin::where('phoneNumber', $request->phoneNumber)->first();

        if (!empty($admin))
        {
            if ($request->password == $admin->password)
            {
                $token = $admin->createToken('userToken')->accessToken;

                $_SESSION['phoneNumber'] = $admin['phoneNumber'];
                $_SESSION['password'] = $admin['password'];

                return response()->json([
                    'user' => new AdminResource($admin),
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'Admin login successfully'
                ]);
            }
        }

        return response()->json([
            'message' => 'password or phoneNumber is wrong'
        ], 400);
        */

        // if (!auth()->attempt($data)) {
        //     return response()->json([
        //         'massege' => 'phoneNumber or password is wrong'
        //     ], 400);
        // }

        // $admin = auth()->user();
        // $token = $admin->createToken('userToken')->accessToken;

        // return response()->json([
        //     'user' => new AdminResource($admin),
        //     'token' => $token,
        //     'token_type' => 'Bearer',
        //     'message' => 'Admin login successfully'
        // ]);
    }

    public function show_users ()
    {
        $users = (new User())->get();

        return response()->json([
            'users' => $users
        ]);
    }

    public function get_users ()
    {
        $users = User::paginate(10);
        // return view('api/admin/users_pagination', compact('users'));
        
        // return compact('users');

        return response()->json([
            'user' => $users
        ]);

    }
}
