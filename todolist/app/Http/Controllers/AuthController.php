<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\UserList;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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
        if(session('token')){
            return redirect()->route('todo');
        }
        else{
            return view('pages.signin');
        }
    }

    public function signup(){
        if(session('token')){
            return redirect()->route('todo');
        }
        else{
            return view('pages.signup');
        }
    }

    public function handleSignup(SignUpRequest $request){
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'username_account' => $request->username,
            'password_account' => Hash::make($request->password),
            'avatar' => 'default.jpg',
            'OTP' => '',
        ]);

        $message = 'Đăng ký tài khoản thành công';
        return redirect()->route('signin')->with('signup', $message);
    }

    public function googleLogin(){
        return Socialite::driver('google')->redirect();
    }

    public function googleLoginHandle(){
        $user = Socialite::driver('google')->user();

        dd($user);
    }

    public function githubLogin(){
        return Socialite::driver('github')->redirect();
    }

    public function githubLoginHandle(){
        $user = Socialite::driver('github')->user();

        dd($user);
    }
}
