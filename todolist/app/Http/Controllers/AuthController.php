<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;

class AuthController extends Controller
{
    public function handleSignin(Request $request){
        // $user = User::where('username_account', $request->username)->first();
        // if($user){
        //     $token = $user->createToken('authToken')->plainTextToken;
        //         return response()->json([
        //             'access_token' => $token,
        //             'type_token' => 'Bearer',
        //             'role' => $user->role,
        //         ], 200);
        // }
        // return '123';
        return $request;
    }

    public function signin(){
        return view('pages.signin');
    }

    public function signup(){
        return view('pages.signup');
    }
}
