<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttributeValueRequest extends FormRequest
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
        $id = $this->route('attributeValue')->id;
        return [
            'value' => ['required', 'string', 'max:255', Rule::unique('attribute_values')->ignore($id)],
            'is_active' => ['nullable', Rule::in([0, 1])],
        ];
    }
    public function messages(): array
    {
        return [
            'value.required' => 'Vui lòng nhập tên thuộc tính.',
            'value.unique' => 'Tên thuộc tính đã tồn tại.',
        ];
        
    }
}
