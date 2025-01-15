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
                'min:0'
            ],
            'usage_limit' => [
                'nullable',
                'integer',
                'min:0'
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
                'nullable',
                'date'
            ],
            'end_date' => [
                'nullable',
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
                'min:0'
            ],
            'coupon_restrictions.valid_categories' => [
                'required',
                'array'
            ],
            'coupon_restrictions.valid_products' => [
                'required',
                'array'
            ],
        ];
    }
}
