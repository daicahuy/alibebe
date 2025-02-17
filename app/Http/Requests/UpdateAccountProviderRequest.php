<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAccountProviderRequest extends FormRequest
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
            'avatar' => ['nullable', 'image', 'max:2048'], 
            'fullname' => ['required', 'string', 'max:50'], 
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(Auth::id())], 
            'phone_number' => ['required', 'regex:/^(\+84|0)[1-9][0-9]{8,9}$/'], 
        ];
    }
    
    
    public function messages(): array
    {
        return [
            'avatar.image' => 'Tệp tải lên phải là một hình ảnh.',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 2MB.',
    
            'fullname.required' => 'Vui lòng nhập họ và tên.',
            'fullname.string' => 'Họ và tên phải là một chuỗi ký tự.',
            'fullname.max' => 'Họ và tên không được vượt quá 50 ký tự.',
    
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email này đã được sử dụng.',
    
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng.',  
        ];
    }
    
}
