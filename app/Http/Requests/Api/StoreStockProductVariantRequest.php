<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStockProductVariantRequest extends FormRequest
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
            'variants' => ['required', 'array', 'min:1'],
            'variants.*.id' => ['required', Rule::exists('product_variants', 'id')],
            'variants.*.quantity' => ['nullable', 'numeric', 'integer', 'gt:0'],
        ];
    }

    public function attributes()
    {
        return [
            'quantity' => 'Số Lượng',
            'variants.*.id' => 'Id',
            'variants.*.quantity' => 'Số Lượng',
        ];
    }
}
