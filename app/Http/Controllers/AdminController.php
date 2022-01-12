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

    public function update_user_profile($id, Request $request)
    {
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'max:55',
            'lastname' => 'max:60',
            'phoneNumber' => 'numeric|min:11|unique:users',
            'password' => 'min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        empty($request->name) ? : $data['name'] = $request->name;
        empty($request->lastname) ? : $data['lastname'] = $request->lastname;
        empty($request->phoneNumber) ? : $data['phoneNumber'] = $request->phoneNumber;
        empty($request->password) ? : $data['password'] = Hash::make($request->password);

        User::where('id',$id)->update($data);

        return response()->json([
            'message' => 'User Information Updated Successfully'
        ]);
    }
}
