<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\VietHoaMoiChuCaiDau;

class SignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => ['required', 'min:3', 'max:30', new VietHoaMoiChuCaiDau, 'not_regex:/[`!@#$%^&*()_+\-=\[\]{};\':"\\\|,.<>\/?~]|\d/'],
            'username' => ['required', 'min:6', 'max:18', 'unique:users,username_account', 'not_regex:/[`!@#$%^&*()_+\-=\[\]{};\':"\\\|,.<>\/?~]|\s/'],
            'email' => ['required', 'email', 'max:64', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8', 'max:64', 'not_regex:/[`()_+\-=\[\]{};\':"\\\|,.<>\/?~]|\s/'],
        ];
    }

    public function messages(): array
    {
        return [
            //full name
            'fullname.required' => ':attribute không được để trống',
            'fullname.min' => ':attribute có độ dài tối thiểu là :min ký tự',
            'fullname.max' => ':attribute có độ dài tối đa là :max ký tự',
            'fullname.not_regex' => ':attribute không được chứa chữ số và các ký tự đặc biệt',

            //username
            'username.required' => ':attribute không được để trống',
            'username.min' => ':attribute có độ dài tối thiểu là :min ký tự',
            'username.max' => ':attribute có độ dài tối đa là :max ký tự',
            'username.not_regex' => ':attribute không được chứa khoảng trắng và các ký tự đặc biệt',
            'username.unique' => ':attribute này đã tồn tại',

            //email
            'email.required' => ':attribute không được để trống',
            'email.email' => ':attribute yêu cầu phải đúng định dạng',
            'email.max' => ':attribute có độ dài tối đa là :max ký tự',
            'email.unique' => ':attribute này đã được sử dụng',

            //password
            'password.required' => ':attribute không được để trống',
            'password.confirmed' => ':attribute xác nhận không trùng khớp',
            'password.not_regex' => ':attribute chỉ được chứa chữ cái, chữ số và các ký tự !@#$%^&*',
            'password.min' => ':attribute có độ dài tối thiểu là :min ký tự',
            'password.max' => ':attribute có độ dài tối đa là :max ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ tên',
            'username' => 'Tên tài khoản',
            'email' => 'Email',
            'password' => 'Mật khẩu',
        ];
    }
}
