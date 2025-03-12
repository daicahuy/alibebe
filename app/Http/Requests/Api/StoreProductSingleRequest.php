<?php

namespace App\Http\Requests\Api;

use App\Enums\ProductType;
use App\Rules\CheckValidSpecificationRule;
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
        return [
            'product'                      =>    ['required', 'array'],
            'product.brand_id'             =>    ['required', Rule::exists('brands', 'id')],
            'product.name'                 =>    ['required', Rule::unique('products', 'name')],
            'product.short_description'    =>    ['required', 'max:255'],
            'product.description'          =>    ['nullable'],
            'product.thumbnail'            =>    ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'product.type'                 =>    ['required', Rule::in([ProductType::SINGLE, ProductType::VARIANT])],
            'product.sku'                  =>    ['required', Rule::unique('products', 'sku'), Rule::unique('product_variants', 'sku')],
            'product.price'                =>    ['required', 'numeric', 'integer', 'gt:0'],
            'product.sale_price'           =>    ['nullable', 'numeric', 'integer', 'gt:0', 'lt:product.price'],
            'product.sale_price_start_at'  =>    ['nullable', 'sometimes', 'required_with:product.sale_price', 'date'],
            'product.sale_price_end_at'    =>    ['nullable', 'sometimes', 'required_with:product.sale_price', 'date', 'after:product.sale_price_start_at'],
            'product.is_sale'              =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_featured'          =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_trending'          =>    ['nullable', Rule::in([0, 1]) ],
            'product.is_active'            =>    ['nullable', Rule::in([0, 1]) ],
            'product_specifications'       =>    ['required', 'array', 'min:1'],
            'product_specifications.*'     =>    [new CheckValidSpecificationRule()],
            'tags'                         =>    ['nullable', 'array'],
            'tags.*'                       =>    [Rule::exists('tags', 'id')],
            'product_stocks'               =>    ['required', 'array', 'min:1'],
            'product_stocks.stock'       =>      ['required', 'numeric', 'integer', 'gte:0'],
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
            'product.brand_id'             => 'Thương Hiệu',  
            'product.name'                 => 'Tên Sản Phẩm',  
            'product.short_description'    => 'Mô Tả Ngắn',  
            'product.description'          => 'Mô Tả Chi Tiết',  
            'product.thumbnail'            => 'Ảnh Đại Diện',  
            'product.type'                 => 'Loại Sản Phẩm',  
            'product.sku'                  => 'Mã Sku',  
            'product.price'                => 'Giá Sản Phẩm',  
            'product.sale_price'           => 'Giá Khuyến Mãi',  
            'product.sale_price_start_at'  => 'Ngày Bắt Đầu Khuyến Mãi',  
            'product.sale_price_end_at'    => 'Ngày Kết Thúc Khuyến Mãi',  
            'product.is_sale'              => 'Trạng Thái Khuyến Mãi',  
            'product.is_featured'          => 'Sản Phẩm Nổi Bật',  
            'product.is_trending'          => 'Sản Phẩm Xu Hướng',  
            'product.is_active'            => 'Trạng Thái Kích Hoạt',
            'product_specifications'       => 'Thông Số Kĩ Thuật',
            'tags'                         => 'Thẻ',
            'product_stocks'               => 'Số Lượng Tồn Kho',  
            'product_stocks.stock'         => 'Số Lượng Tồn Kho',  
            'category_id'                  => 'Danh Mục',  
            'product_accessories'          => 'Phụ Kiện',
            'product_galleries'            => 'Bộ Sưu Tập Ảnh',
        ];
    }

    public function messages()
    {
        return [
            'product.sale_price.lt' => 'Giá Khuyến Mãi phải nhỏ hơn Giá Gốc',
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
