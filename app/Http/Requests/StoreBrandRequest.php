<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
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
            //
            'name' => 'required|string|max:100|unique:brands,name,'.$this->id,
            'logo' => 'required|image|max:2048',
            'is_active' => ['nullable',Rule::in(0,1)]
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên thương hiệu.',
            'name.string'  => 'Tên thương hiệu phải là chuỗi ký tự.',
            'name.max' => 'Tên thương hiệu không được vượt quá 100 ký tự.',
            'name.unique' => 'Tên thương hiệu đã tồn tại.',

            'logo.max' => 'Logo không được vượt quá 2048 ký tự.',
            'logo.required' => 'Vui lòng đặt logo.',
            'logo.image' => 'Logo không đúng định dạng.',

            
        ];
        
    }
}
