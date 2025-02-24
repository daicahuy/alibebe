<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check(); // Yêu cầu người dùng phải đăng nhập
    }

    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Sản phẩm không hợp lệ!',
            'product_id.exists' => 'Sản phẩm không tồn tại!',
            'content.required' => 'Nội dung bình luận không được để trống!',
            'content.string' => 'Nội dung bình luận không hợp lệ!',
            'content.max' => 'Bình luận không được vượt quá 500 ký tự!',
        ];
    }
}

