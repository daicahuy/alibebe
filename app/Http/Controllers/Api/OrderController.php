<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\Admin\OrderService;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
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

    public function countByStatus(Request $request)
    {
        $filters = $request->all();
        $counts = $this->orderService->countOrdersByStatus($filters);
        return response()->json($counts);
    }

    public function getOrderDetail(int $idOrder)
    {

        $listItemOrder = $this->orderService->getOrderDetail($idOrder);
        return response()->json($listItemOrder);
    }

    public function generateInvoice(Request $request)
    {

        $orderData = $request->input('orderData');
        // return response()->json($orderData);

        $pdf = Pdf::loadView('admin.pages.invoices_order', ['orderData' => $orderData]);


        return $pdf->stream('invoice.pdf', ['Attachment' => 0]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
