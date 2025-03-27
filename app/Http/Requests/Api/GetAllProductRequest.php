<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetAllProductRequest extends FormRequest
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
            'productIds' => 'required|array',
            'productIds.*' => ['integer', Rule::exists('products', 'id')],
        ];
    }

    public function attributes()
    {
        return [
            'productIds' => 'Mã sản phẩm',
            'productIds.*' => 'Mã sản phẩm',
        ];
    }
}
