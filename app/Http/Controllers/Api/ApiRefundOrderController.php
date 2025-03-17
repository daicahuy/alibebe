<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\RefundItem;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;
use Validator;

class ApiRefundOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        try {
            //code...

            $filters = $request->all();
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);


            $queryListRefundOrder = Refund::query()
                ->with('order', 'user', 'refundItems')
                ->orderBy('created_at', 'desc');


            foreach ($filters as $key => $value) {
                if ($key == 'search' && isset($value)) {
                    $queryListRefundOrder->where(function ($query) use ($value) {
                        $query->whereHas('order', function ($q) use ($value) {
                            $q->where('code', 'LIKE', "%{$value}%");
                        })
                            ->orWhereHas('user', function ($q) use ($value) {
                                $q->where('fullname', 'LIKE', "%{$value}%")
                                    ->orWhere('phone_number', 'LIKE', "%{$value}%");
                            });
                    });
                }
            }

            $dataListRefundOrder = $queryListRefundOrder->paginate($limit, ['*'], 'page', $page);

            return response()->json([
                'refundOrders' => $dataListRefundOrder->items(),
                'totalPages' => $dataListRefundOrder->lastPage(),
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }

    }

    public function getDataOrderRefund($id)
    {
        try {

            $dataOrderRefund = Refund::query()->where('id', $id)->with('order', 'user', 'refundItems')->first();

            return response()->json(["status" => Response::HTTP_OK, "dataOrderRefund" => $dataOrderRefund]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $adminReason = $request->input('adminReason');
            $idRefund = $request->input('idRefund');

            if ($adminReason) {
                Refund::query()
                    ->where('id', $idRefund)
                    ->update(['admin_reason' => $adminReason, 'status' => 'rejected']);

                return response()->json([
                    "message" => "OK Admin Reason",
                    "status" => Response::HTTP_OK
                ]);

            } else {
                Refund::query()
                    ->where('id', $idRefund)
                    ->update(['status' => 'receiving']);

                return response()->json([
                    "message" => "OK Admin receiving",
                    "status" => Response::HTTP_OK
                ]);
            }



        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function createOrderRefund(Request $request)
    {

        try {
            //code...

            $rules = [
                'reason' => 'required|string',
                'reason_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'bank_account' => 'required|string|max:255',
                'user_bank_name' => 'required|string|max:100',
                'bank_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'dataRefundProducts' => 'required|json'
            ];

            // Định nghĩa các thông báo lỗi
            $messages = [
                'reason.required' => 'Lý do hoàn hàng là bắt buộc.',
                'reason_image.required' => 'Hình ảnh phải là bắt buộc',
                'reason_image.image' => 'Hình ảnh phải là định dạng hình ảnh.',
                'reason_image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
                'reason_image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
                'bank_account.required' => 'Số tài khoản là bắt buộc.',
                'user_bank_name.required' => 'Tên người nhận là bắt buộc.',
                'bank_name.required' => 'Tên ngân hàng là bắt buộc.',
                'phone_number.required' => 'Số điện thoại liên hệ là bắt buộc.',
                'dataRefundProducts.required' => 'Thông tin sản phẩm hoàn tiền là bắt buộc.',
                'dataRefundProducts.json' => 'Thông tin sản phẩm hoàn tiền phải là định dạng JSON.'
            ];

            $validator = Validator::make($request->all(), $rules, $messages);


            $dataRefundProducts = json_decode($request->input('dataRefundProducts'), true);
            $validator->after(function ($validator) use ($dataRefundProducts) {

                if (empty($dataRefundProducts['products'])) {
                    $validator->errors()->add('products', 'Vui lòng chọn sản phẩm hoàn');
                }
            });



            if ($validator->fails()) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errors' => $validator->errors()->toArray(),
                    "data" => $request->all()
                ]);
            }

            $data = $request->all();
            if ($request->hasFile('reason_image')) {
                $data['reason_image'] = Storage::put("orders", $request->file('reason_image'));
            }

            DB::beginTransaction();

            $orderRefund = Refund::create([
                "user_id" => $dataRefundProducts["user_id"],
                "total_amount" => $dataRefundProducts["total_amount"],
                "order_id" => $dataRefundProducts["order_id"],
                "bank_account" => $data["bank_account"],
                "user_bank_name" => $data["user_bank_name"],
                "bank_name" => $data["bank_name"],
                "reason" => $data["reason"],
                "phone_number" => $data["phone_number"],
                "reason_image" => $data["reason_image"],
                "status" => "pending",
            ]);

            $dataItemProduct = [];
            foreach ($dataRefundProducts["products"] as $key => $value) {
                if ($value["productVariantId"]) {
                    $item = OrderItem::where([
                        "product_id" => $value["productId"],
                        "product_variant_id" => $value["productVariantId"],
                        "order_id" => $dataRefundProducts["order_id"]
                    ])->first();
                } else {
                    $item = OrderItem::where([
                        "product_id" => $value["productId"],
                        "order_id" => $dataRefundProducts["order_id"]
                    ])->first();
                }

                if ($item) {
                    array_push($dataItemProduct, $item);
                }
            }

            foreach ($dataItemProduct as $key => $item) {
                RefundItem::create([
                    "refund_id" => $orderRefund["id"],
                    "product_id" => $item["product_id"],
                    "variant_id" => $item["product_variant_id"],
                    "name" => $item["name"],
                    "name_variant" => $item["name_variant"],
                    "quantity" => $item["quantity"],
                    "quantity_variant" => $item["quantity_variant"],
                    "price" => $item["price"],
                    "price_variant" => $item["price_variant"],
                ]);
            }

            Order::where('id', $dataRefundProducts["order_id"])
                ->update(["is_refund" => "0"]);


            DB::commit();
            return response()->json(["data" => $dataItemProduct, "status" => Response::HTTP_OK]);



        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

}
