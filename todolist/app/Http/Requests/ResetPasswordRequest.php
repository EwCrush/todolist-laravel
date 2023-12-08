<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'password' => ['required', 'confirmed', 'min:8', 'max:64', 'not_regex:/[`()_+\-=\[\]{};\':"\\\|,.<>\/?~]|\s/'],
        ];
    }

    public function messages(): array
    {
        return [
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
            'password' => 'Mật khẩu',
        ];
    }
}
