<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        // if(Auth::user()->hasRole('user')){
        if(Auth::user()->hasRole('user')){
            // return "User";
            return response()->json([
                'role' => 'user'
            ]);
        }
        elseif(Auth::user()->hasRole('admin')){
            // return "Admin";
            return response()->json([
                'role' => 'admin'
            ]);
        }
        elseif(Auth::user()->hasRole('viewer')){
            // return "Admin";
            return response()->json([
                'role' => 'viewer'
            ]);
        }
    }
    // public function dashboard(){
    //     return response()->json([
    //         'hello' => 'Welcome'
    //     ]);
    // }
}
