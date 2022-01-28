<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register (Request $request)
    {
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'lastname' => 'required|max:60',
            'phoneNumber' => 'required|numeric|min:11|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $accessToken = $user->createToken('UserToken')->accessToken;

        // $_SESSION['phoneNumber'] = $user['phoneNumber'];
        // $_SESSION['password'] = $user['password'];

        return response()->json([
            'user' => new UserResource($user),
            'token' => $accessToken,
            'token_type' => 'Bearer',
            'massage' => 'User Registered Successfully'
        ]);
    }

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

        if (!auth()->attempt($data)) {
            return response()->json([
                'massege' => 'phoneNumber or password is wrong'
            ], 400);
        }

        $user = auth()->user();
        $tokenResult = $user->createToken('userToken')->accessToken;

        // $_SESSION['phoneNumber'] = $user['phoneNumber'];
        // $_SESSION['password'] = $user['password'];

        return response()->json([
            'user' => new UserResource($user),
            'token' => $tokenResult,
            'token_type' => 'Bearer',
            'massage' => 'User Login Successfully'
        ]);
    }

    public function update_dashboard($id, Request $request)
    {
        // $user_id = $request->user()->id;
        $data = [];
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'max:55',
            'lastname' => 'max:60',
            'password' => 'min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 422);
        }

        empty($request->name) ? : $data['name'] = $request->name;
        empty($request->lastname) ? : $data['lastname'] = $request->lastname;
        empty($request->password) ? : $data['password'] = Hash::make($request->password);

        User::where('id',$id)->update($data);

        return response()->json([
            'message' => 'User Information Updated Successfully',
            // 'message 2' => $user_id

        ]);
    }
}
