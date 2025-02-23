<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePasswordRequest extends FormRequest
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
            'password' => ['required', 'min:6','confirmed'],
            'password_confirmation' => ['required'], // Bắt buộc nhập lại mật khẩu
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Vui Lòng Nhập Lại Mật Khẩu Cũ',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'password_confirmation.required' => 'Vui lòng nhập xác nhận mật khẩu mới.',
        ];
    }
}
