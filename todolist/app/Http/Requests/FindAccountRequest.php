<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindAccountRequest extends FormRequest
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
            'username' => ['required'],
            'email' => ['required', 'email'],
        ];
    }

    public function messages(): array
    {
        return [
            //username
            'username.required' => ':attribute không được để trống',

            //email
            'email.required' => ':attribute không được để trống',
            'email.email' => ':attribute yêu cầu phải đúng định dạng',
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'Tên tài khoản',
            'email' => 'Email',
        ];
    }
}
