<?php

namespace App\Http\Requests\Api;

use App\Enums\ProductType;
use App\Traits\FormatsValidationErrors;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class StoreProductSingleRequest extends FormRequest
{
    use FormatsValidationErrors;
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
        // slug
        return [
            'product'                      =>    ['required', 'array'],
            'product.brand_id'             =>    ['required', Rule::exists('brands', 'id')],
            'product.name'                 =>    ['required', Rule::unique('products', 'name')],
            'product.short_description'    =>    ['required', 'max:255'],
            'product.description'          =>    ['nullable'],
            'product.thumbnail'            =>    ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'product.type'                 =>    ['required', Rule::in([ProductType::SINGLE, ProductType::VARIANT])],
            'product.sku'                  =>    ['required', Rule::unique('products', 'sku')],
            'product.price'                =>    ['required', 'numeric', 'integer', 'gt:0'],
            'product.sale_price'           =>    ['required', 'numeric', 'lt:product.price'],
            'product.sale_price_start_at'  =>    ['required', 'date', 'after:yesterday'],
            'product.sale_price_end_at'    =>    ['required', 'date', 'after:product.sale_price_start_at'],
            'product.is_sale'              =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_featured'          =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_trending'          =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_active'            =>    ['nullable', Rule::in([0, 1]) ],
            'tags'                         =>    ['nullable', 'array'],
            'tags.*'                       =>    [Rule::exists('tags', 'id')],
            'stock'                        =>    ['required', 'numeric', 'integer', 'gte:0'],
            'category_id'                  =>    ['required', Rule::exists('categories', 'id')],
            'product_accessories'          =>    ['nullable', 'array'],
            'product_accessories.*'        =>    [Rule::exists('products', 'id')],
            'product_galleries'            =>    ['required', 'array', 'min:1'],
            'product_galleries.*'          =>    ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function attributes(): array  
    {
        return [  
            'product.brand_id'             => 'Thương hiệu',  
            'product.name'                 => 'Tên sản phẩm',  
            'product.short_description'    => 'Mô tả ngắn',  
            'product.description'          => 'Mô tả chi tiết',  
            'product.thumbnail'            => 'Ảnh đại diện',  
            'product.type'                 => 'Loại sản phẩm',  
            'product.sku'                  => 'Mã sản phẩm',  
            'product.price'                => 'Giá gốc',  
            'product.sale_price'           => 'Giá khuyến mãi',  
            'product.sale_price_start_at'  => 'Ngày bắt đầu khuyến mãi',  
            'product.sale_price_end_at'    => 'Ngày kết thúc khuyến mãi',  
            'product.is_sale'              => 'Trạng thái khuyến mãi',  
            'product.is_featured'          => 'Sản phẩm nổi bật',  
            'product.is_trending'          => 'Sản phẩm xu hướng',  
            'product.is_active'            => 'Trạng thái kích hoạt',  
            'tags'                         => 'Thẻ',
            'stock'                        => 'Số lượng tồn kho',  
            'category_id'                  => 'Danh mục',  
            'product_accessories'          => 'Phụ kiện',
            'product_galleries'            => 'Thư viện ảnh',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['product']['slug'] = Str::slug($data['product']['name']);
        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'message' => 'An error occurred, please check again !',
            'errors' => $this->formatErrors($validator->errors()->toArray())
        ];

        throw new HttpResponseException(response()->json($response, 422));

    }
}
