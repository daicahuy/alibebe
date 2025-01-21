<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\Admin\OrderService;
use Exception;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

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

        $orders = $this->orderService->getOrders($filters, $page, $limit);

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


            if ($note) {
                $this->orderService->changeNoteStatusOrder($idOrder, $note);

            } else {

                $this->orderService->changeStatusOrder($idOrder, $idStatus);
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
