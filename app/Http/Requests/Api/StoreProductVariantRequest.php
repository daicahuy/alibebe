<?php

namespace App\Http\Requests\Api;

use App\Enums\ProductType;
use App\Rules\CheckUniqueSkuProductRule;
use App\Rules\CheckUniqueSkuVariantRule;
use App\Rules\CheckValidSpecificationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreProductVariantRequest extends FormRequest
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
            'product'                                   =>    ['required', 'array'],
            'product.brand_id'                          =>    ['required', Rule::exists('brands', 'id')],
            'product.name'                              =>    ['required', Rule::unique('products', 'name')],
            'product.short_description'                 =>    ['required', 'max:255'],
            'product.description'                       =>    ['nullable'],
            'product.thumbnail'                         =>    ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'product.type'                              =>    ['required', Rule::in([ProductType::SINGLE, ProductType::VARIANT])],
            'product.sku'                               =>    ['required', Rule::unique('products', 'sku'), Rule::unique('product_variants', 'sku'), new CheckUniqueSkuProductRule()],
            'product.sale_price_start_at'               =>    ['nullable', 'sometimes', 'required_with:product.is_sale', 'date'],
            'product.sale_price_end_at'                 =>    ['nullable', 'sometimes', 'required_with:product.is_sale', 'date', 'after:product.sale_price_start_at'],
            'product.is_sale'                           =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_featured'                       =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_trending'                       =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_active'                         =>    ['nullable', Rule::in([0, 1]) ],
            'product_specifications'                    =>    ['required', 'array', 'min:1'],
            'product_specifications.*'                  =>    [new CheckValidSpecificationRule()],
            'tags'                                      =>    ['nullable', 'array'],
            'tags.*'                                    =>    [Rule::exists('tags', 'id')],
            'category_id'                               =>    ['required', Rule::exists('categories', 'id')],
            'product_accessories'                       =>    ['nullable', 'array'],
            'product_accessories.*'                     =>    [Rule::exists('products', 'id')],
            'product_galleries'                         =>    ['required', 'array', 'min:1'],
            'product_galleries.*'                       =>    ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'product_variants'                          =>    ['required', 'array', 'min:1'],
            'product_variants.*.variant'                =>    ['required', 'array', 'min:1'],
            'product_variants.*.variant.*'              =>    [Rule::exists('attribute_values', 'id')],
            'product_variants.*.info'                   =>    ['required', 'array'],
            'product_variants.*.info.sku'               =>    ['required', Rule::unique('products', 'sku'), Rule::unique('product_variants', 'sku'), new CheckUniqueSkuVariantRule()],
            'product_variants.*.info.price'             =>    ['required', 'numeric', 'integer', 'gt:0'],
            'product_variants.*.info.sale_price'        =>    ['nullable', 'sometimes', 'required_with:product.is_sale', 'numeric', 'integer', 'gt:0', 'lt:product_variants.*.info.price'],
            'product_variants.*.info.thumbnail'         =>    ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'product_variants.*.info.is_active'         =>    ['nullable', Rule::in([0, 1]) ],
            'product_variants.*.product_stocks'         =>    ['required', 'array', 'min:1'],
            'product_variants.*.product_stocks.stock'   =>    ['required', 'numeric', 'integer', 'gt:0'],
        ];
    }

    public function attributes(): array  
    {
        return [  
            'product.brand_id'                          => 'Thương Hiệu',  
            'product.name'                              => 'Tên Sản Phẩm',  
            'product.short_description'                 => 'Mô Tả Ngắn',  
            'product.description'                       => 'Mô Tả Chi Tiết',  
            'product.thumbnail'                         => 'Ảnh Đại Diện',  
            'product.type'                              => 'Loại Sản Phẩm',  
            'product.sku'                               => 'Mã Sku Sản Phẩm',
            'product.sale_price_start_at'               => 'Ngày Bắt Đầu Khuyến Mãi',  
            'product.sale_price_end_at'                 => 'Ngày Kết Thúc Khuyến Mãi',  
            'product.is_sale'                           => 'Trạng Thái Khuyến Mãi',  
            'product.is_featured'                       => 'Sản Phẩm Nổi Bật',  
            'product.is_trending'                       => 'Sản Phẩm Xu Hướng',  
            'product.is_active'                         => 'Trạng Thái',
            'product_specifications'                    => 'Thông Số Kĩ Thuật',
            'tags'                                      => 'Thẻ',
            'category_id'                               => 'Danh Mục',  
            'product_accessories'                       => 'Phụ Kiện',
            'product_galleries'                         => 'Bộ Sưu Tập Ảnh',
            'product_variants.*.variant.*'              => 'Thuộc Tính',
            'product_variants.*.info.sku'               => 'Mã Sku',
            'product_variants.*.info.price'             => 'Giá',
            'product_variants.*.info.sale_price'        => 'Giá khuyến mãi',
            'product_variants.*.info.thumbnail'         => 'Ảnh',
            'product_variants.*.info.is_active'         => 'Trạng thái',
            'product_variants.*.product_stocks'         => 'Tồn kho',
            'product_variants.*.product_stocks.stock'   => 'Tồn kho',
        ];
    }

    public function messages()
    {
        return [
            'product_variants.*.info.sale_price.lt' => 'Giá Khuyến Mãi phải nhỏ hơn Giá Gốc',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        $data['product']['slug'] = Str::slug($data['product']['name']);

        if (isset($data['product']['is_sale']) && $data['product']['is_sale'] == null) {
            $data['product']['sale_price_start_at'] = null;
            $data['product']['sale_price_end_at'] = null;
        }
        
        return $data;
    }
}
