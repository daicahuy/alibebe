<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountPasswordRequest extends FormRequest
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
        $user = auth()->user();
        $isGoogleUserWithoutPassword = $user->google_id && !$user->password;

        // Nếu người dùng đăng nhập bằng Google và chưa có mật khẩu
        if ($isGoogleUserWithoutPassword) {
            return [
                'new_password' => ['required', 'min:6'],
                'password_confirmation' => ['required', 'same:new_password'],
            ];
        }

        // Cho người dùng thông thường hoặc người dùng Google đã có mật khẩu
        return [
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6'],
            'password_confirmation' => ['required', 'same:new_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'password_confirmation.required' => 'Vui lòng nhập xác nhận mật khẩu mới.',
        ];
    }
}
