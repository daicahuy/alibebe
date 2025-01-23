<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTagRequest extends FormRequest
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
            'name' => ['required','max:255',Rule::unique('tags')->ignore('id')]
        ];
    }
    public function messages(): array {
        return [
            'name.required' => 'Vui lòng điền tên thẻ',
            'name.max' => 'Tên thẻ vượt quá ký tự cho phép!',
            'name.unique' => 'Tên thẻ đã tồn tại!'
        ];
    }
}
