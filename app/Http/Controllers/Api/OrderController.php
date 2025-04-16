<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderLockStatus;
use App\Events\OrderPendingCountUpdated;
use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Jobs\UnlockOrderJob;
use App\Enums\NotificationType;
use App\Events\OrderCustomer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderOrderStatus;
use App\Models\ProductStock;
use App\Models\User;
use App\Models\UserOrderCancel;
use App\Services\Api\Admin\OrderService;
use App\Services\OrderCancelService;
use Auth;
use DB;
use Exception;
use Illuminate\Http\Request;
use Log;
use PDF;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;
use Storage;
use Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $filters = $request->all();
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $user_id = $request->input('user_id');
        $role_user = $request->input('role_user');

        $orders = $this->orderService->getOrders($filters, $page, $limit, $user_id, $role_user);

        return response()->json([
            'orders' => $orders->items(),
            'totalPages' => $orders->lastPage(),
        ]);
    }

    public function getOrdersByUser(Request $request)
    {
        $filters = $request->all();
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $user_id = $request->input('user_id');
        $search = $request->input('search');

        $orders = $this->orderService->getOrdersByUser($filters, $page, $limit, $user_id, $search);

        return response()->json([
            'orders' => $orders->items(),
            'totalPages' => $orders->lastPage(),
        ]);
    }

    public function getOrderDetail(int $idOrder)
    {

        $listItemOrder = $this->orderService->getOrderDetail($idOrder);
        $listStatusHistory = $this->orderService->getListStatusHistory($idOrder);
        return response()->json([
            "listItemOrder" => $listItemOrder,
            'listStatusHistory' => $listStatusHistory
        ]);
    }

    public function generateInvoice(Request $request)
    {
        $data = $request->input('orderData');
        // Kiểm tra dữ liệu
        if (empty($data)) {
            return back()->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        }

        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('Incoice');
        $html = view()->make("admin.pages.invoices_order", ['dataOrder' => $data])->render();
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', '', 8);
        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf->Output("name", "I");

    }

    public function generateInvoiceAll(Request $request)
    {

        // Kiểm tra dữ liệu

        try {

            $activeTab = $request->input('activeTab');

            $idOrders = $request->input('idOrders');

            if ($activeTab) {
                $orders = $this->orderService->getOrdersByStatus($activeTab);
            }
            if ($idOrders) {
                $orders = $this->orderService->getOrdersByID($idOrders);
            }

            $ordersArray = $orders->toArray();


            $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            $pdf->SetAuthor('Nicola Asuni');
            $pdf->SetTitle('Incoice');
            foreach ($ordersArray as $key => $data) {
                $html = view()->make("admin.pages.invoices_order_list", ['dataOrder' => $data])->render();
                $pdf->AddPage();
                $pdf->SetFont('dejavusans', '', 8);
                $pdf->writeHTML($html, true, false, true, false, '');
            }

            return $pdf->Output("name", "I");



        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
        // if (empty($data)) {
        //     return back()->with('error', 'Dữ liệu đơn hàng không hợp lệ.');
        // }

        // $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // $pdf->SetAuthor('Nicola Asuni');
        // $pdf->SetTitle('Incoice');
        // $html = view()->make("admin.pages.invoices_order", ['dataOrder' => $data])->render();
        // $pdf->AddPage();
        // $pdf->SetFont('dejavusans', '', 8);
        // $pdf->writeHTML($html, true, false, true, false, '');

        // return $pdf->Output("name", "I");

    }

    public function changeStatusOrder(Request $request)
    {
        try {

            $idOrder = $request->input("order_id");
            $idStatus = $request->input("status_id");
            $user_id = $request->input("user_id");
            $note = $request->input("note");

            $order = Order::query()->where('id', $idOrder)->with('orderItems', 'orderStatuses')->first();

            DB::beginTransaction();

            $orderArray = $order->toArray();
            if ($orderArray['order_statuses'][0]['id'] == 1 && $idStatus == 6) {





                foreach ($orderArray['order_items'] as $key => $value) {
                    if ($value['product_variant_id']) {
                        $itemStock = ProductStock::where('product_variant_id', $value['product_variant_id'])->first();

                        $itemStock->stock = $itemStock->stock + (INT) $value['quantity_variant'];
                        $itemStock->save();

                    } else {
                        $itemStock = ProductStock::where('product_id', $value['product_id'])->first();

                        $itemStock->stock = $itemStock->stock + (INT) $value['quantity'];
                        $itemStock->save();
                    }
                }

                 $admins = User::where('role', 2)
                        ->orWhere('role', 1)
                        ->get();

            $message = "Đơn Hàng {$order->code} đã bị hủy !";

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'message' => $message,
                    'read' => false,
                    'type' => NotificationType::Order,
                    'order_id' => $order->id
                ]);
            }

            event(new OrderCustomer($order, $message));
            $user = User::find($user_id);
            // return response()->json(["user" => $user]);
            if ($orderArray['order_statuses'][0]['id'] == 1 && $idStatus == 6 && $user->role == 0) {
                UserOrderCancel::create([
                    'user_id' => $user_id,
                ]);
            }

            }


            DB::commit();


            if ($note) {
                $this->orderService->changeNoteStatusOrder($idOrder, $note);

            } else {
                if ($orderArray['order_statuses'][0]['id'] == 1 && $idStatus == 6 && $user->role == 0) {

                    $this->orderService->changeStatusOrder($idOrder, $idStatus, null);
                    if (is_array($idOrder)) {
                        foreach ($idOrder as $key => $value) {
                            # code...
                            event(new OrderStatusUpdated($value, $idStatus, $order, null));
                            event(new OrderPendingCountUpdated());
                        }
                    } else {
                        event(new OrderStatusUpdated($idOrder, $idStatus, $order, null));
                        event(new OrderPendingCountUpdated());


                    }


                } else {
                    $this->orderService->changeStatusOrder($idOrder, $idStatus, $user_id);
                    if (is_array($idOrder)) {
                        foreach ($idOrder as $key => $value) {
                            # code...
                            event(new OrderStatusUpdated($value, $idStatus, $order, $user_id));
                            event(new OrderPendingCountUpdated());
                        }
                    } else {
                        event(new OrderStatusUpdated($idOrder, $idStatus, $order, $user_id));
                        event(new OrderPendingCountUpdated());


                    }
                }
            }


            if ($orderArray['order_statuses'][0]['id'] == 1 && $idStatus == 6 && $user->role == 0) {
                $orderCancelService = new OrderCancelService();
                $response = $orderCancelService->checkAndApplyPenalty($user_id);



                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    return response()->json([
                        'message' => 'Tài khoản đã bị khóa',
                        'status' => Response::HTTP_OK,
                        'should_logout' => true
                    ]);
                }
            }




            return response()->json([
                'message' => 'Query executed successfully',
                'status' => Response::HTTP_OK,

            ]);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function updateOrderStatusWithUserCheck(Request $request)
    {
        try {

            $idOrder = $request->input("order_id");
            $idStatus = $request->input("status_id");
            $customerCheck = $request->input("customer_check");
            $order = Order::query()->where('id', $idOrder)->with('orderItems', 'orderStatuses')->first();

            $this->orderService->updateOrderStatusWithUserCheck($idOrder, $idStatus, $customerCheck);
            event(new OrderStatusUpdated($idOrder, $idStatus, $order));
            event(new OrderPendingCountUpdated());


            return response()->json([
                'message' => 'Query executed successfully',
                'status' => Response::HTTP_OK,

            ]);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function uploadImgConfirm(Request $request, int $idOrder)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_evidence' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Điều chỉnh max size nếu cần
                'note' => 'nullable|string|max:255',
            ]);

            $data = $request->all();

            if ($validator->fails()) {
                return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
            }

            if ($request->hasFile('employee_evidence')) {
                $data['employee_evidence'] = Storage::put("orders", $request->file('employee_evidence'));
            }
            $order = Order::query()->where('id', $idOrder)->with('orderItems', 'orderStatuses')->first();

            $this->orderService->updateConfirmCustomer($data["note"], $data["employee_evidence"], $idOrder);
            event(new OrderStatusUpdated($idOrder, 4, $order, ""));
            event(new OrderPendingCountUpdated());

            return response()->json(["data" => $data, "status" => Response::HTTP_OK]);





        } catch (\Throwable $e) {
            //throw $th;

            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function countByStatus(Request $request)
    {
        $filters = $request->all();
        $counts = $this->orderService->countOrdersByStatus($filters);
        return response()->json($counts);
    }

    public function getOrderOrderByStatus(Request $request)
    {
        try {

            $idOrder = $request->input("order_id");
            $data = $this->orderService->getOrderOrderStatusByID($idOrder);


            return response()->json([
                "data" => $data,
                'message' => 'Query executed successfully',
                'status' => Response::HTTP_OK,

            ]);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function countPending(Request $request)
    {
        try {
            $count = OrderOrderStatus::query()->where("order_status_id", 1)->count();
            return response()->json(['count' => $count]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function getOrder(int $idOrder)
    {

        $order = Order::query()->where("id", $idOrder)->with(["user"])->first();

        return response()->json([
            "status" => Response::HTTP_OK,
            "order" => $order
        ]);
    }

    public function changeStatusRefundMoney(Request $request)
    {
        try {
            $data = $request->all();
            $orderId = $data["idorder"];
            if ($request->hasFile('img_send_money')) {
                $data['img_send_money'] = Storage::put("orders", $request->file('img_send_money'));
            } else {
                $data['img_send_refund_money'] = null;
            }
            $status = 1;

            Order::where("id", $orderId)->update(["is_refund_cancel" => $status, "img_send_refund_money" => $data['img_send_money']]);
            return response()->json(["status" => Response::HTTP_OK, "data" => $orderId]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }
    public function userCheckRefundMoney(Request $request)
    {
        try {
            $orderId = $request->input('order_id');
            $status = $request->input('status');

            Order::where("id", $orderId)->update(["check_refund_cancel" => $status]);
            return response()->json(["status" => Response::HTTP_OK, "data" => $orderId]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function lockOrder(Request $request)
    {
        try {
            $orderId = $request->input("order_id");
            $userID = $request->input('user_id');
            Log::info($orderId);
            if (is_array($orderId)) {
                $numericOrderIds = array_map('intval', $orderId);
                Order::whereIn("id", $numericOrderIds)->update(["locked_status" => 1]);
                foreach ($numericOrderIds as $id) {
                    event(new OrderLockStatus($id, $status = 1, $userID));
                    dispatch(new UnlockOrderJob($id))->delay(now()->addSeconds(60));
                }

                return response()->json([
                    "status" => Response::HTTP_OK,
                    "data" => $numericOrderIds
                ]);
            } else {

                Order::where("id", $orderId)->update(["locked_status" => 1]);
                event(new OrderLockStatus($orderId, $status = 1, $userID));
                dispatch(new UnlockOrderJob($orderId))->delay(now()->addSeconds(60));
                return response()->json(["status" => Response::HTTP_OK, "data" => $orderId]);

            }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function unlockOrder(Request $request)
    {
        try {
            $orderId = $request->input("order_id");
            $userID = $request->input('user_id');
            if (is_array($orderId)) {
                $numericOrderIds = array_map('intval', $orderId);

                Order::whereIn("id", $numericOrderIds)->update(["locked_status" => 0]);
                foreach ($numericOrderIds as $id) {
                    event(new OrderLockStatus($id, $status = 0, $userID));
                }

                return response()->json([
                    "status" => Response::HTTP_OK,
                    "data" => $numericOrderIds
                ]);
            } else {

                Order::where("id", $orderId)->update(["locked_status" => 0]);
                event(new OrderLockStatus($orderId, $status = 0, $userID));
                return response()->json(["status" => Response::HTTP_OK, "data" => $orderId]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function checkLockOrder(Request $request)
    {
        try {
            $orderId = $request->input("order_id");

            if (is_array($orderId)) {
                $numericOrderIds = array_map('intval', $orderId);

                $orders = collect(); // Khởi tạo một collection rỗng
                foreach ($numericOrderIds as $id) {
                    $order = Order::where('id', $id)->where('locked_status', 1)->first(['id', 'code', 'locked_status']);
                    if ($order) {
                        $orders->push($order);
                    }
                }
                if ($orders->isEmpty()) {
                    return response()->json([
                        "status" => Response::HTTP_OK,
                        "data" => [],
                        "message" => "No orders found for the given IDs."
                    ]);
                }

                // Trả về danh sách trạng thái locked của từng order
                $result = $orders->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'code' => $order->code,
                        'locked' => $order->locked_status
                    ];
                });

                return response()->json([
                    "status" => Response::HTTP_OK,
                    "data" => $result
                ]);
            } else {

                $order = Order::find($orderId);
                if ($order) {
                    return response()->json(["status" => Response::HTTP_OK, 'locked' => $order->locked_status]);
                }
                return response()->json(["status" => Response::HTTP_OK, 'locked' => false], 404);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }
}
