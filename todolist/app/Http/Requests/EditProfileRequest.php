<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\VietHoaMoiChuCaiDau;

class EditProfileRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:64'],
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

            //email
            'email.required' => ':attribute không được để trống',
            'email.email' => ':attribute yêu cầu phải đúng định dạng',
            'email.max' => ':attribute có độ dài tối đa là :max ký tự',
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ tên',
            'email' => 'Email',
        ];
    }
}
