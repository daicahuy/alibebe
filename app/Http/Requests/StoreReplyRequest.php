<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReplyRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check(); // Yêu cầu đăng nhập
    }

    public function rules()
    {
        return [
            'comment_id' => 'required|exists:comments,id',
            'content' => 'required|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'comment_id.required' => 'Bình luận không hợp lệ!',
            'comment_id.exists' => 'Bình luận không tồn tại!',
            'content.required' => 'Nội dung phản hồi không được để trống!',
            'content.string' => 'Nội dung phản hồi không hợp lệ!',
            'content.max' => 'Phản hồi không được vượt quá 500 ký tự!',
        ];
    }
}
