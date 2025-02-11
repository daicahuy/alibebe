<?php

namespace App\Http\Requests;

use App\Enums\CouponDiscountType;
use App\Enums\CouponExpiredType;
use App\Enums\UserGroupType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StoreCouponRequest extends FormRequest
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
        $isExpired = $this->input('is_expired');
        $allProducts = $this->input('is_apply_all');
        return [
            'code' => [
                'required',
                Rule::unique('coupons'),
                'string',
                'max:50'
            ],
            'title' => [
                'required',
                'string',
                'max:50'
            ],
            'description' => [
                'nullable',
                'string',
                'max:255'
            ],
            'discount_type' => [
                'required',
                Rule::in([
                    CouponDiscountType::FIX_AMOUNT,
                    CouponDiscountType::PERCENT
                ]),
            ],
            'discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    // Kiểm tra nếu discount_type là PERCENT và giá trị nằm ngoài khoảng 1 - 100%
                    if (request('discount_type') == CouponDiscountType::PERCENT && ($value < 0 || $value > 100)) {
                        $fail('Giá trị giảm giá phải nằm trong khoảng 1 - 100%.');
                    }
                }
            ],
            'usage_limit' => [
                'nullable',
                'integer',
                'min:0',
                'max:100'
            ],
            'usage_count' => [
                'nullable',
                'integer',
                'min:0'
            ],
            'user_group' => [
                'nullable',
                Rule::in([
                    UserGroupType::ALL,
                    UserGroupType::NEWBIE,
                    UserGroupType::IRON,
                    UserGroupType::BRONZE,
                    UserGroupType::SILVER,
                    UserGroupType::GOLD,
                    UserGroupType::PLATINUM,
                    UserGroupType::DIAMOND
                ])
            ],
            'is_expired' => [
                'nullable',
                Rule::in([
                    CouponExpiredType::NOT_EXPIRED,
                    CouponExpiredType::EXPIRED
                ]),
                'integer'
            ],
            'is_active' => [
                'nullable',
                Rule::in([0, 1])
            ],
            'start_date' => [
                $isExpired == CouponExpiredType::EXPIRED ? 'required' : 'nullable',
                'date'
            ],
            'end_date' => [
                $isExpired == CouponExpiredType::EXPIRED ? 'required' : 'nullable',
                'date',
                'after_or_equal:start_date'
            ],
            'coupon_restrictions.min_order_value' => [
                'nullable',
                'numeric',
                'min:0'
            ],
            'coupon_restrictions.max_discount_value' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    // Kiểm tra nếu discount_type là PERCENT và giá trị vượt mức 85%
                    if (request('discount_type') == CouponDiscountType::PERCENT && $value > 85) {
                        $fail('Giá trị Tối Đa Giảm Giá Không Được Hơn 85%.');
                    }

                    // Kiểm tra nếu discount_type là FIX_AMOUNT và max_discount_value không được lớn hơn discount_value
                    if (request('discount_type') == CouponDiscountType::FIX_AMOUNT && (float)$value > (float)request('discount_value')) {
                        $fail('Giá trị tối đa giảm giá không được lớn hơn giá trị giảm giá.');
                    }
                }
            ],
            'coupon_restrictions.valid_categories' => [
                'required',
                'array'
            ],
            'coupon_restrictions.valid_products' => [
                $allProducts == 'on' ? 'nullable' : 'required',
                'array'
            ],
        ];
    }
}
