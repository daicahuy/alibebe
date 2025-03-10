<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttributeRequest extends FormRequest
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
        $id = $this->route('attribute')->id;
        return [
           'name' => ['required', 'string', 'max:255', Rule::unique('attributes')->ignore($id)],
            'is_variant' => ['nullable', Rule::in([0, 1])],
            'is_active' => ['nullable', Rule::in([0, 1])],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên thuộc tính.',
            'name.unique' => 'Tên thuộc tính đã tồn tại.',
        ];
        
    }
}
