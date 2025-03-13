<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductStock;
use App\Services\Api\Admin\OrderService;
use DB;
use Exception;
use Illuminate\Http\Request;
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

    public function hoanhang()
    {
        return view('client.pages.hoanhang');
    }


    public function index(Request $request)
    {
        $filters = $request->all();
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $orders = $this->orderService->getOrders($filters, $page, $limit);

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
            $note = $request->input("note");

            $order = Order::query()->where('id', $idOrder)->with('orderItems', 'orderStatuses')->first();

            DB::beginTransaction();

            $orderArray = $order->toArray();
            if ($orderArray['order_statuses'][0]['id'] == 1 && $idStatus == 7) {

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

            }

            DB::commit();




            if ($note) {
                $this->orderService->changeNoteStatusOrder($idOrder, $note);

            } else {

                $this->orderService->changeStatusOrder($idOrder, $idStatus);
                if (is_array($idOrder)) {
                    foreach ($idOrder as $key => $value) {
                        # code...
                        event(new OrderStatusUpdated($value, $idStatus));
                    }
                } else {
                    event(new OrderStatusUpdated($idOrder, $idStatus));

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

            $this->orderService->updateOrderStatusWithUserCheck($idOrder, $idStatus, $customerCheck);
            event(new OrderStatusUpdated($idOrder, $idStatus));


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

            $this->orderService->updateConfirmCustomer($data["note"], $data["employee_evidence"], $idOrder);
            event(new OrderStatusUpdated($idOrder, 4));




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
}
