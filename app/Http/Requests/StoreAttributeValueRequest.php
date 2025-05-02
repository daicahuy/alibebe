<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttributeValueRequest extends FormRequest
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
           'value' => ['required', 'string', 'max:255', Rule::unique('attribute_values')],
            'is_active' => ['nullable', Rule::in([0, 1])],
        ];
    }
    public function messages(): array
    {
        return [
            'value.required' => 'Vui lòng nhập tên thuộc tính.',
            'value.unique' => 'Tên thuộc tính đã tồn tại.',
            'value.max' => 'Tên thuộc tính không được vượt quá 255 ký tự.',
        ];
        
    }
}
