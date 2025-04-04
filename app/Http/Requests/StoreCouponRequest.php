<?php

namespace App\Http\Requests;

use App\Enums\CouponDiscountType;
use App\Enums\CouponExpiredType;
use App\Enums\UserGroupType;
use App\Models\Coupon;
use App\Models\Order;
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
        // $allProducts = $this->input('is_apply_all');
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
                'after_or_equal:start_date',
                'after_or_equal:today'
            ],
            'coupon_restrictions.min_order_value' => [
                'required',
                function ($attribute, $value, $fail) {
                    $discountType = request('discount_type');
                    $discountValue = (float) request('discount_value'); // % giảm giá

                    // Kiểm tra nếu discount_type là phần trăm và discount_value vượt quá 20%
                    if ($discountType == CouponDiscountType::PERCENT && $discountValue > 20) {
                        // Nếu min_order_value bằng 0, báo lỗi yêu cầu phải có giá trị đơn hàng tối thiểu
                        if ($value == 0) {
                            $fail('Khi giảm giá vượt quá 20%, yêu cầu phải có giá trị đơn hàng tối thiểu.');
                        }

                    }
                },
                'numeric',
                'min:0',
            ],

            'coupon_restrictions.max_discount_value' => [
                'required_if:discount_type,' . CouponDiscountType::PERCENT,
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    // Lấy loại giảm giá và giá trị giảm giá từ request
                    $discountType = request('discount_type');
                    $discountValue = (float) request('discount_value'); // % giảm giá
                    $minOrderValue = (float) request('coupon_restrictions.min_order_value'); // Giá trị đơn hàng tối thiểu

                    // Nếu loại giảm giá là phần trăm và min_order_value lớn hơn 0
                    if ($discountType == CouponDiscountType::PERCENT && $minOrderValue > 0) {
                        // Tính số tiền giảm giá tối đa dựa trên % giảm giá và min_order_value
                        $calculatedMaxDiscount = ($discountValue / 100) * $minOrderValue;

                        // Kiểm tra nếu max_discount_value lớn hơn số tiền giảm giá tối đa cho phép
                        if ($value > $calculatedMaxDiscount) {
                            $fail('Số tiền giảm giá tối đa không được vượt quá ' . $calculatedMaxDiscount . ' (tương đương ' . $discountValue . '% của giá trị đơn hàng tối thiểu là ' . $minOrderValue . ').');
                        }
                    }
                }
            ],
        ];
    }
}
