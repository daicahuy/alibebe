<?php

namespace App\Http\Requests;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
        $brandId = $this->route('brand')->id;
        return [
            //
            'name' => ['required','string','max:100',Rule::unique('brands')->ignore($brandId)],
            'logo' => 'nullable|image|max:2048',
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
            'logo.image' => 'Logo không đúng định dạng.',
        ];
        
    }
}
