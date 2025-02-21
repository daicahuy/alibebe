<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListCategoriesFilterRequest extends FormRequest
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
            'min_price' => 'nullable|numeric|min:0|lte:max_price',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
        ];
    }

    public function attributes()
    {
        return [
            'min_price' => __('form.product.min_price'),
            'max_price' => __('form.product.max_price'),
        ];
    }

    public function messages()
    {
        return [
            'min_price.numeric' => __('validation.numeric', ['attribute' => __('form.product.min_price')]),
            'max_price.numeric' => __('validation.numeric', ['attribute' => __('form.product.max_price')]),
            'min_price.min' => __('validation.min.numeric', ['attribute' => __('form.product.min_price'), 'min' => 0]),
            'max_price.max' => __('validation.max.numeric', ['attribute' => __('form.product.max_price'), 'min' => 0]),
            'min_price.lte' => __('validation.lte', ['attribute' => __('form.product.min_price'), 'orther' => __('form.product.max_price')]),
            'max_price.gte' => __('validation.gte', ['attribute' => __('form.product.max_price'), 'orther' => __('form.product.min_price')]),
        ];
    }
}