<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;
class AuthController extends ApiController
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $user->attachRole('3');
        // $user->attachRole($request->role_id);
        $token = $user->createToken('apiToken')->plainTextToken;
        return $this->created([
            'role' => 'This is a new user role.',    
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ], 'User registration successful');

    }
    public function login(Request $request){
        // $request->validate([
        //     'email' => 'required|unique:users,email',
        //     'password' => 'required|min:6',
        // ]);
        // $user = User::where('email', $request->email)->first();
        // if (!$user || !Hash::check($request->password, $user->password)){
        //     return response()->json([
        //         'message' => 'User registration failed. Incorrect email or password.'
        //     ]);
        // }
        // $token = $user->createTocken('apiToken');
        // return response()->json([
        //     'message' => 'User login successful.',
        //     'user' => $user,
        //     'token' => $token
        // ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            return response()->json([
                // 'role_id' => $roles->role_id,
                'token' =>$user->createToken('apiToken')->plainTextToken,
                'user' => $user,
                'message' => 'User login successfully.'
            ]);
        } 
        else{ 
            return ['Unauthorised.'];
        } 
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        // Auth::user()->tokens()->delete();
        // Auth::logout();
        // $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User logout successful.'
        ]);
    }

}