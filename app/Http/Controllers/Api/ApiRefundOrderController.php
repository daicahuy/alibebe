<?php

namespace App\Http\Controllers\api;

use App\Enums\NotificationType;
use App\Enums\UserRoleType;
use App\Events\BankInfoChanged;
use App\Events\BankInfoChangedForAll;
use App\Events\OrderCustomer;
use App\Events\OrderRefundCustomer;
use App\Events\OrderRefundPendingCountUpdated;
use App\Events\RefundOrderCreate;
use App\Events\RefundOrderUpdateStatus;
use App\Events\SendConfirmOrderToAdmin;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Refund;
use App\Models\RefundItem;
use App\Models\User;
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
            $user_role = $request->input('user_role');
            $user_id = $request->input('user_id');


            $queryListRefundOrder = Refund::query()
                ->with('order', 'user')->with([

                        'refundItems' => function ($query) {
                            $query->with("product");
                        }
                    ])
                ->orderBy('created_at', 'desc');
            if ($user_role == 1) {
                $queryListRefundOrder->where(function ($q) use ($user_id) {
                    $q->where('user_handle', $user_id)
                        ->orWhereIn('status', ['pending', 'cancel']);
                });
            }

            foreach ($filters as $key => $value) {
                if ($key == 'search' && isset($value)) {
                    $queryListRefundOrder->where(function ($query) use ($value) {
                        $query->whereHas('order', function ($q) use ($value) {
                            $q->where('code', 'LIKE', "%{$value}%");
                        })
                            ->orWhereHas('user', function ($q) use ($value) {
                                $q->where('fullname', 'LIKE', "%{$value}%")
                                    ->orWhere('phone_number', 'LIKE', "%{$value}%");
                            })->orWhereHas('refundItems', function ($q) use ($value) {
                                $q->where('name', 'LIKE', "%{$value}%")->orWhere('name_variant', 'LIKE', "%{$value}%");
                            });
                        ;
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

            $dataOrderRefund = Refund::query()->where('id', $id)->with('order', 'user', 'handleUser')->with([

                'refundItems' => function ($query) {
                    $query->with("product");
                }
            ])->first();

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
            $user_handle = $request->input('user_handle');

            if ($adminReason) {
                Refund::query()
                    ->where('id', $idRefund)
                    ->update(['admin_reason' => $adminReason, 'status' => 'rejected', 'user_handle' => $user_handle]);
                event(new RefundOrderUpdateStatus($idRefund, 'rejected'));
                event(new OrderRefundPendingCountUpdated());
                return response()->json([
                    "message" => "OK Admin Reason",
                    "status" => Response::HTTP_OK
                ]);

            } else {
                Refund::query()
                    ->where('id', $idRefund)
                    ->update(['status' => 'receiving', 'user_handle' => $user_handle]);
                event(new RefundOrderUpdateStatus($idRefund, 'receiving'));
                event(new OrderRefundPendingCountUpdated());


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

    public function changeStatusCancelOrder(Request $request)
    {
        try {
            $idOrder = $request->input("idOrder");



            Refund::query()
                ->where('id', $idOrder)
                ->update(['status' => 'cancel']);
            event(new RefundOrderUpdateStatus($idOrder, 'cancel'));
            event(new OrderRefundPendingCountUpdated());

            return response()->json([
                "message" => "OK Admin Reason",
                "status" => Response::HTTP_OK
            ]);


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
                'reason_image' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:20480',
                'bank_account' => 'required|string|max:255|regex:/^\d+$/',
                'user_bank_name' => 'required|string|max:100',
                'bank_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'dataRefundProducts' => 'required|json'
            ];

            // Định nghĩa các thông báo lỗi
            $messages = [
                'reason.required' => 'Lý do hoàn hàng là bắt buộc.',
                'reason_image.required' => 'Hình ảnh hoặc video là bắt buộc.',
                'reason_image.file' => 'Tệp phải là hình ảnh hoặc video.',
                'reason_image.mimes' => 'Hình ảnh hoặc video phải có định dạng jpeg, png, jpg, gif, mp4, mov hoặc avi.',
                'reason_image.max' => 'Kích thước tệp không được vượt quá 20MB.',
                'bank_account.required' => 'Số tài khoản là bắt buộc.',
                'bank_account.max' => 'Số tài khoản tối đa là 255 ký tự.',
                'bank_account.regex' => 'Số tài khoản phải chỉ chứa các chữ số.',
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
                    $item["count"] = $value["count"];
                    $item["price_total_product"] = $value["price"];
                } else {
                    $item = OrderItem::where([
                        "product_id" => $value["productId"],
                        "order_id" => $dataRefundProducts["order_id"]
                    ])->first();
                    $item["count"] = $value["count"];
                    $item["price_total_product"] = $value["price"];
                }

                if ($item) {
                    array_push($dataItemProduct, $item);
                }
            }

            foreach ($dataItemProduct as $key => $item) {
                if ($item["product_variant_id"]) {
                    RefundItem::create([
                        "refund_id" => $orderRefund["id"],
                        "product_id" => $item["product_id"],
                        "variant_id" => $item["product_variant_id"],
                        "name" => $item["name"],
                        "name_variant" => $item["name_variant"],
                        "quantity" => $item["quantity"],
                        "quantity_variant" => $item["count"],
                        "price" => $item["price"],
                        "price_variant" => $item["price_variant"],
                    ]);
                } else {
                    RefundItem::create([
                        "refund_id" => $orderRefund["id"],
                        "product_id" => $item["product_id"],
                        "variant_id" => $item["product_variant_id"],
                        "name" => $item["name"],
                        "name_variant" => $item["name_variant"],
                        "quantity" => $item["count"],
                        "quantity_variant" => $item["quantity_variant"],
                        "price" => $item["price"],
                        "price_variant" => $item["price_variant"],
                    ]);
                }
            }

            Order::where('id', $dataRefundProducts["order_id"])
                ->update(["is_refund" => "1"]);

            $order = Order::find($orderRefund->order_id);

            $message = "Khách hàng yêu cầu hoàn đơn {$order->code} (tổng {$orderRefund->total_amount}đ).";

            $admins = User::whereIn('role', [1,2])->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id'   => $admin->id,
                    'message'   => $message,
                    'read'      => false,
                    'type'      => NotificationType::Refund,
                    // 'order_id'  => $order->id,
                    'refund_id' => $orderRefund->id,
                ]);
            }


            event(new OrderRefundCustomer($orderRefund , $message));
            event(new RefundOrderCreate($orderRefund));
            event(new OrderRefundPendingCountUpdated());


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

    public function getOrdersRefundByUser(Request $request)
    {
        $filters = $request->all();
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $user_id = $request->input('user_id');


        $queryListRefundOrder = Refund::query()->where('user_id', $user_id)
            ->with('order', 'user')->with([

                    'refundItems' => function ($query) {
                        $query->with("product");
                    }
                ])
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
                        })
                        ->orWhereHas('refundItems', function ($q) use ($value) {
                            $q->where('name', 'LIKE', "%{$value}%")->orWhere('name_variant', 'LIKE', "%{$value}%");
                        });
                });
            }
        }

        $dataListRefundOrder = $queryListRefundOrder->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'refundOrders' => $dataListRefundOrder->items(),
            'totalPages' => $dataListRefundOrder->lastPage(),
        ]);
    }

    public function changeStatusWithImg(Request $request)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('img_fail_or_completed')) {
                $data['img_fail_or_completed'] = Storage::put("orders", $request->file('img_fail_or_completed'));
            } else {
                $data['img_fail_or_completed'] = null;
            }

            $id_order_refund = $data["id_order_refund"];
            $fail_reason = $data["fail_reason"];

            DB::beginTransaction();

            if ($fail_reason) {
                Refund::where("id", $id_order_refund)->update(["fail_reason" => $fail_reason, "img_fail_or_completed" => $data['img_fail_or_completed'], "status" => "failed"]);
                event(new RefundOrderUpdateStatus($id_order_refund, 'failed'));
                event(new OrderRefundPendingCountUpdated());


            } else {
                Refund::where("id", $id_order_refund)->update(["img_fail_or_completed" => $data['img_fail_or_completed'], "status" => "completed"]);
                event(new RefundOrderUpdateStatus($id_order_refund, 'completed'));
                event(new OrderRefundPendingCountUpdated());


            }

            DB::commit();


            return response()->json(["status" => Response::HTTP_OK, "data" => $data]);



        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function countPending(Request $request)
    {
        try {
            $count = Refund::query()->where("status", 'pending')->count();
            return response()->json(['count' => $count]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function sentConfirmBank(Request $request)
    {
        try {
            $idOrderRefund = $request->input('id_order_refund');
            $status = $request->input('status');

            Refund::where('id', $idOrderRefund)->update(["bank_account_status" => $status]);
            event(new RefundOrderUpdateStatus($idOrderRefund, 'receiving'));

            return response()->json(["status" => Response::HTTP_OK, "idOrderRefund" => $idOrderRefund]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function sentConfirmOrderWithAdmin(Request $request)
    {
        try {
            $idOrderRefund = $request->input('id_order_refund');
            $status = $request->input('status');

            Refund::where('id', $idOrderRefund)->update(["confirm_order_with_admin" => $status]);

            $refund = Refund::with('order','user')->find($idOrderRefund);

            $admins = User::where('role',UserRoleType::ADMIN)->get();
            $message = "Yêu cầu xác nhận hoàn tiền đơn {$refund->order->code}";

            foreach($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => $message,
                    'read' => false,
                    'type' => NotificationType::Confirm,
                    'order_id' => $refund->order->id,
                    'refund_id' => $refund->id,
                ]);
            }

            event(new SendConfirmOrderToAdmin($refund, $message));

            return response()->json(["status" => Response::HTTP_OK, "idOrderRefund" => $idOrderRefund]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function confirmBank(Request $request)
    {
        try {
            $rules = [
                'bank_account' => 'required|string|max:255|regex:/^\d+$/',
                'user_bank_name' => 'required|string|max:100',
                'bank_name' => 'required|string|max:255',

            ];

            // Định nghĩa các thông báo lỗi
            $messages = [
                'bank_account.required' => 'Số tài khoản là bắt buộc.',
                'bank_account.max' => 'Số tài khoản tối đa là 255 ký tự.',
                'bank_account.regex' => 'Số tài khoản phải chỉ chứa các chữ số.',
                'user_bank_name.required' => 'Tên người nhận là bắt buộc.',
                'user_bank_name.max' => 'Tên người nhận tối đa là 100 ký tự',
                'bank_name.required' => 'Tên ngân hàng là bắt buộc.',
                'bank_name.max' => 'Tên ngân hàng tối đa là 255 ký tự',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => Response::HTTP_BAD_REQUEST,
                    'errors' => $validator->errors()->toArray(),
                    "data" => $request->all()
                ]);
            }


            $refund = Refund::find($request->input('idOrder'));

            $changes = [];
            if ($refund) {
                if ($refund->bank_account != $request->input('bank_account')) {
                    $changes['bank_account'] = [
                        'old' => $refund->bank_account,
                        'new' => $request->input('bank_account'),
                    ];
                }
                if ($refund->user_bank_name != $request->input('user_bank_name')) {
                    $changes['user_bank_name'] = [
                        'old' => $refund->user_bank_name,
                        'new' => $request->input('user_bank_name'),
                    ];
                }
                if ($refund->bank_name != $request->input('bank_name')) {
                    $changes['bank_name'] = [
                        'old' => $refund->bank_name,
                        'new' => $request->input('bank_name'),
                    ];
                }
            }

            Refund::where('id', $request->input('idOrder'))->update(["bank_account_status" => "verified", "bank_account" => $request->input('bank_account'), "bank_name" => $request->input('bank_name'), "user_bank_name" => $request->input('user_bank_name')]);

            if (!empty($changes)) {

                //Thông báo đến admin khi người dùng thay đổi thông tin chuyển khoản  

                $order = Order::find($refund->order_id);
                $orderCode = $order ? $order->code : 'N/A';

                // Lấy danh sách thay đổi để hiển thị trong thông báo
                $changeText = '';
                foreach ($changes as $field => $value) {
                    switch ($field) {
                        case 'bank_account':
                            $changeText .= "Số tài khoản: {$value['old']} => {$value['new']}; ";
                            break;
                        case 'user_bank_name':
                            $changeText .= "Tên người nhận: {$value['old']} => {$value['new']}; ";
                            break;
                        case 'bank_name':
                            $changeText .= "Tên ngân hàng: {$value['old']} => {$value['new']}; ";
                            break;
                    }
                }

                // Tạo nội dung thông báo
                $message = "Khách hàng đã thay đổi thông tin ngân hàng cho đơn hoàn tiền #{$orderCode}: $changeText";

                // Trường hợp nếu có nhân viên xử lý
                if ($refund->user_handle) {
                    // Gửi thông báo cho nhân viên xử lý
                    Notification::create([
                        'user_id'   => $refund->user_handle,
                        'message'   => $message,
                        'read'      => false,
                        'type'      => NotificationType::Bank,
                        'order_id'  => $refund->order_id,
                        'refund_id' => $refund->id,
                    ]);

                    // Thông báo real-time cho nhân viên xử lý
                    event(new BankInfoChanged($refund->id, $changes, $message, $refund->user_handle));
                } else {
                    // Nếu chưa có nhân viên xử lý, gửi cho tất cả admin
                    $admins = User::whereIn('role', [1, 2])->get(); // Role 1: Admin, 2: Staff

                    foreach ($admins as $admin) {
                        Notification::create([
                            'user_id' => $admin->id,
                            'message' => $message,
                            'read' => false,
                            'type' => NotificationType::Refund,
                            'order_id' => $refund->order_id,
                            'refund_id' => $refund->id,
                        ]);
                    }

                    // Thông báo real-time cho tất cả admin
                    event(new BankInfoChangedForAll($refund->id, $changes, $message));
                }


            }




            event(new RefundOrderUpdateStatus($request->input('idOrder'), 'receiving'));

            return response()->json(["status" => Response::HTTP_OK, "data" => $request->all()]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function userCheckReceivedBank(Request $request)
    {
        try {
            $statusCheckReceived = $request->input('statusCheckReceived');
            $idOrder = $request->input('idOrder');


            Refund::where('id', $idOrder)->update(["is_send_money" => $statusCheckReceived]);

            event(new RefundOrderUpdateStatus($idOrder, 'receiving'));

            return response()->json(["status" => Response::HTTP_OK, "data" => $request->all()]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }


    public function confirmRefundByAdmin(Request $request)
    {
        $request->validate([
            'id_order_refund' => 'required|integer|exists:refunds,id',
            'action' => 'required|in:accept,reject',
        ]);

        try {
            $idOrderRefund = $request->get('id_order_refund');
            $action = $request->get('action');

            $admins = User::where('role', UserRoleType::ADMIN)
            ->get(['id','fullname']);


            $status = $action === 'accept' ? 1 : 0;

            Refund::where('id', $idOrderRefund)->update([
                'confirm_order_with_admin' => $status
            ]);

            $refund = Refund::with('order', 'user')->find($idOrderRefund);

            $message = $status
                ? "Admin đã đồng ý yêu cầu hoàn tiền đơn hàng {$refund->order->code}."
                : "Admin đã từ chối yêu cầu hoàn tiền đơn hàng {$refund->order->code}.";

                foreach ($admins as $admin) {
                    Notification::create([
                        'user_id' => $admin->id,
                        'message' => $message,
                        'read' => false,
                        'type' => NotificationType::Confirm,
                        'order_id' => $refund->order->id,
                        'refund_id' => $refund->id,
                    ]);
                }

            return response()->json([
                'status' => Response::HTTP_OK,
                'message' => $message
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ]);
        }
    }


}
