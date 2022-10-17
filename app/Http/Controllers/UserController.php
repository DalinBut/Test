<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
        // public function __construct()
        // {
        //     $this->middleware(['role:admin']);
        // }

        public function index(Request $request)
        {
            if(Auth::user()->hasRole('admin')){
                // $user = User::all();
                // $user = User::orderBy('name', 'ASC')->get();
                $user = DB::table('users')->select('name', 'email')->get();
                return response()->json([
                    'user' => $user
                    
                ]);
            }
        }

       
        public function create()
        {
            //
        }

        
        public function store(Request $request)
        {
            if(Auth::user()->hasRole('admin')){

                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique|users',
                    'password' => 'required|min:6',
                ]);
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                return response()->json([
                    'message' => 'User successfully created',
                    'user' => $user
                ]);
            }elseif(Auth::user()->hasRole('user') || Auth::user()->hasRole('viewer')){
                return ['Cannot Create With This Role.'];
            }
        }

        
        public function show($id)
        {
            //
        }

        
        public function edit($id)
        {
            //
        }

        
        public function update(Request $request, User $user)
        {
            if(Auth::user()->hasRole('admin')){
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|min:6',
                ]);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                $token = $user->createToken('apiToken')->plainTextToken;
                return response()->json([
                    'message' => 'User successfully updated',
                    'user' => $user,
                    'token'=> $token
                ]);
            }else{
                return ['Cannot Update'];
            }
        }

        public function destroy(User $user)
        {
            if(Auth::user()->hasRole('admin')){
                $user->delete();
                return response()->json([
                    'message' => 'User successfully deleted',
                    'user' => $user
                ]);
            }else{
                return ['Cannot Delete.'];
            }
        }
}
