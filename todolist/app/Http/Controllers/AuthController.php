<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\UserList;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\FindAccountRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use JD\Cloudder\Facades\Cloudder;
use Laravel\Sanctum\PersonalAccessToken;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;

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

    public function home(){
        if(session('token')){
            return redirect()->route('todo');
        }
        else{
            return view('pages.landing');
        }
    }

    public function logout(){
        $access_token = session('token')['access_token'];
        $personalAccessToken = PersonalAccessToken::findToken($access_token);
        if ($personalAccessToken) {
            // Lấy ra người dùng của token
            $user = $personalAccessToken->tokenable;

            // Xóa tất cả các token của người dùng
            $user->tokens()->delete();

            // Xoá token hiện tại
            $personalAccessToken->delete();

            // Đặt session token thành null
            session(['token' => null]);

            return redirect()->route('signin');
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
        return redirect()->route('signin')->with('success', $message);
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

    public function editProfile(EditProfileRequest $request){
        $user = $request->user();
        if($user->social_id) return response()->json(['status'=> 404, 'message'=>'Bạn không có quyền này!'], 404);
        if ($user->email != $request->email) {
            $checkEmail = User::where('id', '!=', $user->_id)->where('email', $request->email)->first();
            if ($checkEmail) {
                return response()->json(['status' => 422, 'errors' => ['email' => ['Email này đã tồn tại']]], 422);
            }
        }
        User::where('id', $user->id)->update([
            'fullname' => $request->fullname,
            'email' => $request->email
        ]);
        return response()->json(['status' => 200, 'message' => 'Cập nhật thông tin thành công'], 200);
    }

    public function changePassword(ChangePasswordRequest $request){
        $user = $request->user();
        if(Hash::check($request->oldpassword, $user->password_account)){
            $user->update([
                'password_account' => Hash::make($request->newpassword),
            ]);
            return response()->json(['status' => 200, 'message' => 'Cập nhật thông tin thành công'], 200);
        }
        else {
            return response()->json(['status' => 422, 'errors' => ['oldpassword' => ['Mật khẩu cũ sai']]], 422);
        }
    }

    public function findaccount(){
        return view('pages.findaccount');
    }

    public function handleFindAccount(FindAccountRequest $request){
        $user = User::where('email', $request->email)->where('username_account', $request->username)->first();
        if(!$user){
            $message = 'Thông tin tài khoản không tồn tài!';
            return back()->with('cannotFind', $message)->withInput();
        }
        $otp = Str::random(64);
        $email = $request->email;
        $user->update([
            'otp' => $otp,
        ]);
        $root = $request->root();
        $url = $root.'/resetpassword/'.$otp;

        $mail = new PHPMailer;
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'vanvanvan1972001@gmail.com'; // your email id
        $mail->Password = 'dlvglztwuweyniic'; // your password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.

        $mail->setFrom('vanvanvan1972001@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Reset your password";
        $mail->Body = '<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
        <div style="margin:50px auto;width:70%;padding:20px 0">
          <div style="border-bottom:1px solid #eee">
            <a href="" style="font-size:1.4em;color: #3060FF;text-decoration:none;font-weight:600">Any.do</a>
          </div>
          <p style="font-size:1.1em">Xin chào,</p>
          <p>Đây là URL để đặt lại mật khẩu của bạn, vui lòng giữ bí mật và không tiết lộ URL này cho bên thứ 3.</p>
          <a href='.$url.' style="display: block; background: #3060FF;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px; text-decoration: none;">RESET PASSWORD HERE</a>
          <p>Hoặc bạn cũng có thể sao chép URL dưới đây: <span style="color: #3060FF; text-decoration: underline;">'.$url.'</span></p>
          <p style="font-size:0.9em;">Trân trọng,<br/>Đội ngũ Any.do</p>
          <hr style="border:none;border-top:1px solid #eee" />
          <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
            <p>Any.do</p>
          </div>
        </div>
      </div>';

        $mail->send();

        $message = 'Chúng tôi đã gửi một URL để đặt lại mật khẩu đến địa chỉ email của bạn, vui lòng kiểm tra!';
        return back()->with('isExist', $message)->withInput();
    }

    public function resetpassword($otp){
        return view('pages.reset');
    }

    public function handleResetPassword($otp, ResetPasswordRequest $request){
        $user = User::where('OTP', $otp)->first();
        if(!$user){
            $message = 'Thông tin tài khoản không tồn tài!';
            return back()->with('cannotFind', $message)->withInput();
        }
        $user->update([
            'password_account' => Hash::make($request->password),
            'OTP' => '',
        ]);
        $message = 'Đặt lại mật khẩu thành công!';
        return redirect()->route('signin')->with('success', $message);
    }
}
