<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function handleSignin(Request $request){
        $user = User::where('username_account', $request->username)->first();
        if(!$user){
            $message = 'Thông tin đăng nhập không tồn tài!';
            return back()->with('LoginFailed', $message)->withInput();
        }
        else{
            if(Hash::check($request->password, $user->password_account)){
                $token = $user->createToken('authToken')->plainTextToken;
                $data = [
                    'access_token' => $token,
                    'type_token' => 'Bearer',
                ];
                session()->put('token', $data);
                return redirect()->route('todo');
            }
            else{
                $message = 'Sai mật khẩu!';
                return back()->with('LoginFailed', $message)->withInput();
            }
        }
    }

    public function signin(){
        return view('pages.signin');
    }

    public function signup(){
        return view('pages.signup');
    }
}
