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
use Carbon\Carbon;
use JD\Cloudder\Facades\Cloudder;

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
            'avatar' => 'default',
            'OTP' => '',
        ]);

        $message = 'Đăng ký tài khoản thành công';
        return redirect()->route('signin')->with('signup', $message);
    }

    public function socialLogin($social){
        return Socialite::driver($social)->redirect();
    }

    public function socialLoginHandle($social){
        $user = Socialite::driver($social)->user();
        $social_id = $user->id;
        $isExist = User::where('social_id', $social_id)->first();

        if(!$isExist){
            $imgURL = $user->avatar;
            $filename = $user->id.'_'.Carbon::now()->format('YmdHis');
            Cloudder::upload($imgURL, 'avatar/' . $filename);

            $newUser = User::create([
                'fullname' => $user->name,
                'email' => $user->email,
                'avatar' => $filename,
                'social_id' => $social_id
            ]);

            $token = $newUser->createToken('authToken')->plainTextToken;
                $data = [
                    'access_token' => $token,
                    'type_token' => 'Bearer',
                ];
            session()->put('token', $data);
            return redirect()->route('todo');
        }
        else{
            $token = $isExist->createToken('authToken')->plainTextToken;
            $data = [
                'access_token' => $token,
                'type_token' => 'Bearer',
            ];
            session()->put('token', $data);
            return redirect()->route('todo');
        }
    }

    public function uploadImg(Request $request){
        $user_id = session('dataTodoMiddleware')['user']->id;
        if (!$request->hasFile('image')) return back();
        // Kiểm tra loại MIME của file
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileMimeType = $request->file('image')->getMimeType();

        // Nếu loại MIME không nằm trong danh sách cho phép
        if (!in_array($fileMimeType, $allowedMimeTypes)) return back();
        // Nếu loại MIME nằm trong danh sách cho phép
        $user = User::where('id', $user_id)->first();
        $imgURL = $request->image;
        $filename = 'user-'.$user_id.'_'.Carbon::now()->format('YmdHis');
        Cloudder::upload($imgURL, 'avatar/' . $filename);

        if($user->avatar!='default') {
            Cloudder::delete('avatar/'.$user->avatar);
        }

        $user->update([
            'avatar' => $filename,
        ]);

        return back();
    }
}
