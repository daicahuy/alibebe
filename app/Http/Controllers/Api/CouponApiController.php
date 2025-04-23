<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponRestriction;
use App\Models\CouponUser;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CouponApiController extends Controller
{
    public function listCouponByUser(Request $request, $idUser)
    {
        try {
            $code = $request->query('code');
            $total_amount = $request->query('total_amount');
            // return response()->json(["status" => Response::HTTP_OK, "$code" => $code]);

            if ($code) {
                $listCouponsByUser = CouponUser::query()->where("user_id", $idUser)->where("amount", ">", 0)->whereHas('coupon', function ($query) use ($code) {
                    $query->where("code", "LIKE", '%' . $code . '%')->where('usage_limit', ">", 0);
                    $query->where(function ($q) {
                        $q->where('is_expired', 1)
                            ->where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->orWhere('is_expired', 0);
                    });
                })->with([
                            'coupon' => function ($query) use ($code) {
                                $query->with("restriction");
                            }
                        ])->get()->sortByDesc(function ($couponUser) use ($total_amount) {
                            // Lấy min_order_value từ restriction
                            $minOrderValue = (float) ($couponUser->coupon->restriction->min_order_value ?? 0);
                            // So sánh total_amount với min_order_value
                            return (float) ($total_amount) > $minOrderValue ? 1 : 0;
                        });
                ;
            } else {
                $listCouponsByUser = CouponUser::query()
                    ->where("user_id", $idUser)
                    ->where("amount", ">", 0)->whereHas('coupon', function ($query) use ($code) {
                        $query->where('usage_limit', ">", 0);
                        $query->where(function ($q) {
                            $q->where('is_expired', 1)
                                ->where('start_date', '<=', now())
                                ->where('end_date', '>=', now())
                                ->orWhere('is_expired', 0);
                        });
                    })
                    ->with([
                        'coupon' => function ($query) {
                            $query->with("restriction");
                        }
                    ])
                    ->get()
                    ->sortByDesc(function ($couponUser) use ($total_amount) {
                        // Lấy min_order_value từ restriction
                        $minOrderValue = (float) ($couponUser->coupon->restriction->min_order_value ?? 0);
                        // So sánh total_amount với min_order_value
                        return (float) ($total_amount) > $minOrderValue ? 1 : 0;
                    });
            }
            return response()->json(["status" => Response::HTTP_OK, "listCouponsByUser" => $listCouponsByUser->values()]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function getValueDiscount(Request $request)
    {
        try {

            $discountCode = $request->input('discountCode');
            $user_id = $request->input('user_id');

            $data = $request->all();
            $dataDiscount = [];
            $rules = [
                'discountCode' => ['required', 'max:50'],
                'user_id' => ['required'],

            ];

            $messages = [
                'discountCode.required' => 'Vui lòng nhập Mã.',
                'discountCode.max' => 'Tối đa 50 ký tự!',
            ];
            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }
            $coupon = Coupon::where('code', $data["discountCode"])->where("is_active", 1)->first();

            $validator->after(function ($validator) use ($request, $data, $coupon) {

                if (!$coupon) {
                    $validator->errors()->add('discountCode', 'Mã giảm giá không tồn tại!');
                }
            });

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }

            $couponRestrictions = CouponRestriction::where('coupon_id', $coupon->id)->first();

            $validator->after(function ($validator) use ($request, $data, $coupon, $couponRestrictions) {

                if (!$coupon) {
                    $validator->errors()->add('discountCode', 'Mã giảm giá không tồn tại!');
                } else if ($coupon->is_expired == 1 && (now()->lt($coupon->start_date) || now()->gt($coupon->end_date))) {
                    $validator->errors()->add('discountCode', 'Mã giảm giá hết hạn!');
                } else if ($coupon->usage_limit !== null && $coupon->usage_count >= $coupon->usage_limit) {
                    $validator->errors()->add('discountCode', 'Mã giảm giá hết lượt sử dụng!');
                } else if ($couponRestrictions && $couponRestrictions->min_order_value !== null && $data["total_amount"] < $couponRestrictions->min_order_value) {
                    $validator->errors()->add('discountCode', 'Giá trị đơn hàng tối thiểu là ' . number_format($couponRestrictions->min_order_value) . '!');
                }
            });

            if ($validator->fails()) {
                return ['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'errors' => $validator->errors()->toArray()];
            }

            $discountValue = 0;
            if ($coupon->discount_type === 1) {
                $discountValue = ($data["total_amount"] * $coupon->discount_value) / 100;

                if ($couponRestrictions && $couponRestrictions->max_discount_value !== null && $discountValue > $couponRestrictions->max_discount_value) {
                    $discountValue = $couponRestrictions->max_discount_value; // Giới hạn giá trị giảm
                }
            } else {
                $discountValue = $coupon->discount_value;

            }

            $dataDiscount = [
                'coupon_id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type,
                'discount_value' => $coupon->discount_value, // Giá trị gốc của mã giảm giá (ví dụ: 10% hoặc 10000)
                'discount_amount' => $discountValue, // Giá trị giảm giá thực tế đã tính toán
                'max_discount_value' => $couponRestrictions ? $couponRestrictions->max_discount_value : null,
            ];



            return response()->json(["status" => Response::HTTP_OK, "dataDiscount" => $dataDiscount]);



        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }
}
