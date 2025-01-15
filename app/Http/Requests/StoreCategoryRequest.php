<?php

namespace App\Http\Requests;

use App\Enums\CategoryStatusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
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
            'parent_id' => 'nullable|integer|exists:categories,id',
            'icon' => 'nullable|image|max:2048',
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')
            ],
            // 'slug' => 'required|string|max:100|unique:categories,slug',
            'ordinal' => 'nullable|integer|min:0',
            'is_active' => [
                'nullable',
                Rule::in([
                    CategoryStatusType::INACTIVE,
                    CategoryStatusType::ACTIVE
                ])
            ],
        ];


    }
    public function attributes(): array
    {
        return [
            'name'       => __('form.category.name'),
            'created_at' => __('form.category.created_at'),
            'updated_at' => __('form.category.updated_at'),
            'is_active'  => __('form.category.is_active'),
            'icon'       => __('form.category.icon'),
            'parent_id'  => __('form.category.parent_id'),
            'ordinal'    => __('form.category.ordinal'),
            // ... các trường khác
        ];
    }
    public function messages(): array
    {
        return [
            'name.required'     => __('validation.required', ['attribute' => __('form.category.name')]),
            'name.max'          => __('validation.max.string', ['attribute' => __('form.category.name'), 'max' => 100]),
            'name.unique'       => __('validation.unique', ['attribute' => __('form.category.name')]),
            'parent_id.integer' => __('validation.integer', ['attribute' => __('form.category.parent_id')]),
            'parent_id.exists'  => __('validation.exists', ['attribute' => __('form.category.parent_id')]),
            'icon.image'        => __('validation.image', ['attribute' => __('form.category.icon')]),
            'icon.max'          => __('validation.max.file', ['attribute' => __('form.category.icon'), 'max' => 2048]),
            'ordinal.integer'   => __('validation.integer', ['attribute' => __('form.category.ordinal')]),
            'ordinal.min'       => __('validation.min.numeric', ['attribute' => __('form.category.ordinal'), 'min' => 0]),
            'is_active.in'      => __('validation.in', ['attribute' => __('form.category.is_active')]),
        ];
    }


}
