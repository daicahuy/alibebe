<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStockProductRequest extends FormRequest
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
            'user_id' => ['required', Rule::exists('users', 'id')],
            'singleProducts' => ['nullable', 'array'],
            'singleProducts.*.id' => ['required', Rule::exists('products', 'id')],
            'singleProducts.*.quantity' => ['nullable', 'numeric', 'integer', 'gt:0'],
            'variantProducts' => ['nullable', 'array'],
            'variantProducts.*.id' => ['required', Rule::exists('product_variants', 'id')],
            'variantProducts.*.quantity' => ['nullable', 'numeric', 'integer', 'gt:0'],
        ];
    }

    public function attributes()
    {
        return [
            'quantity' => 'Số Lượng',
            'singleProducts.*.id' => 'Id',
            'singleProducts.*.quantity' => 'Số Lượng',
            'variantProducts.*.id' => 'Id',
            'variantProducts.*.quantity' => 'Số Lượng',
        ];
    }
}
