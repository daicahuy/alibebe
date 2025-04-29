<?php

namespace App\Services\Web\Admin;

use App\Models\OrderOrderStatus;
use App\Repositories\OrderOrderStatusRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserEmployeeService
{
    protected $userRepository;
    protected OrderOrderStatusRepository $orderOrderStatusRepo;
    protected OrderRepository $orderRepo;


    public function __construct(UserRepository $userRepository, OrderOrderStatusRepository $orderOrderStatusRepo, OrderRepository $orderRepo)
    {
        $this->userRepository = $userRepository;
        $this->orderOrderStatusRepo = $orderOrderStatusRepo;
        $this->orderRepo = $orderRepo;
    }

    public function detail($userId, $startDate = null, $endDate = null, $filterStatus)
    {
        // địa chỉ
        $user = $this->userRepository->getUserAndAddress($userId, ['id', 'phone_number', 'email', 'fullname', 'avatar', 'loyalty_points', 'role', 'status', 'created_at']);
        $defaultAddress = $user->addresses->where('is_default', 1)->first();

        $accountCreatedAt = $this->userRepository->getTimeActivity($userId);
        $countOrder = $this->orderRepo->countOrderByEmployeeId($userId);

        //III báo cáo chi tiết

        //1. Tổng quan đơn hàng
        $order = $this->orderRepo->countOrderDetailForEmployee($userId, $startDate, $endDate);
        $orderSuccess = $order['countSuccessDetail']; // số lg đơn thành công
        $orderFalse = $order['countFalseDetail'];
        $orderCance = $order['countCancelDetail'];
        $orderProcessing = $order['countProcessingDetail'];
        $orderShip = $order['countShipDetail'];
        $orderRefund = $order['countRefundDetail'];
        $allOrders = $order['countAllDetail'];// tổng số đơn

        //2. Doanh số
        $successFullRevenue = $order['revenueSuccessDetail']; // doanh thu đơn thành công
        $falseRevenue = $order['revenueFalseDetail'];
        $cancelledRevenue = $order['revenueCancelDetail']; // doanh thu hủy
        $processingRevenue = $order['revenueProcessingDetail']; // doanh thu đang xử lý
        $shipRevenue = $order['revenueShipDetail']; // doanh thu đang giao
        $refundRevenue = $order['revenueRefundDetail']; // doanh thu hoàn hàng
        $totalRevenue = $this->orderRepo->getTotalRevenueForEmployee($userId, $startDate, $endDate); //tổng doanh thu


        // dd($totalRevenue);
        // tính phần trăm doanh thu và số lượng đơn thành công
        $percentCountSuccess = 0;
        $percentPriceSuccess = 0;
        if ($allOrders > 0) { // Sử dụng $allOrders từ countOrderDetailForEmployee
            $percentCountSuccess = round(($orderSuccess / $allOrders) * 100, 2);
            $percentCountFalse = round(($orderFalse / $allOrders) * 100, 2);
            $percentCountCancel = round($order['countCancelDetail'] / $allOrders * 100, 2);
            $percentCountProcessing = round($order['countProcessingDetail'] / $allOrders * 100, 2);
            $percentCountShip = round($order['countShipDetail'] / $allOrders * 100, 2);
            $percentCountRefund = round($order['countRefundDetail'] / $allOrders * 100, 2);

            $percentPriceSuccess = round($successFullRevenue / $totalRevenue * 100, 2);
            // if ($totalRevenue > 0) {

            // }

        }

        //3. Chi Tiết Đơn Hàng
        $orderDetails = [
            [
                'type' => 'Đang xử lý',
                'quantity' => $orderProcessing,
                'revenue' => $processingRevenue,
                'percentCount' => $percentCountProcessing ?? 0,
                'badge_class' => 'bg-warning',
            ],
            [
                'type' => 'Đang giao hàng',
                'quantity' => $orderShip,
                'revenue' => $shipRevenue,
                'percentCount' => $percentCountShip ?? 0,
                'badge_class' => 'bg-info',
            ],
            [
                'type' => 'Giao hàng thất bại',
                'quantity' => $orderFalse,
                'revenue' => $falseRevenue,
                'percentCount' => $percentCountFalse ?? 0,
                'badge_class' => 'btn-secondary',
            ],
            [
                'type' => 'Đã hoàn thành',
                'quantity' => $orderSuccess,
                'revenue' => $successFullRevenue,
                'percentCount' => $percentCountSuccess ?? 0,
                'badge_class' => 'bg-success',
            ],
            [
                'type' => 'Đã hủy',
                'quantity' => $orderCance,
                'revenue' => $cancelledRevenue,
                'percentCount' => $percentCountCancel ?? 0,
                'badge_class' => 'bg-danger',
            ],

            [
                'type' => 'Hoàn hàng',
                'quantity' => $orderRefund,
                'revenue' => $refundRevenue,
                'percentCount' => $percentCountRefund ?? 0,
                'badge_class' => 'bg-dark',
            ],
        ];

        // 4. Phương thức thanh toán

        $paymentMethods = $this->orderRepo->getPaymentMethodForEmployee($userId, $startDate, $endDate);
        // dd($paymentMethods);
        $paymentMethodData = [];
        if ($allOrders > 0 && $totalRevenue > 0) { // Sử dụng $allOrders từ countOrderDetailForEmployee
            foreach ($paymentMethods as $payment) {

                $paymentMethodData[] = [
                    'name' => $payment['payment_method'],
                    'quantity' => $payment['order_count'],
                    'revenue' => $payment['total_revenue'],
                    'percentCount' => round(($payment['order_count'] / $allOrders) * 100, 2) ?? 0,
                    'percentPrice' => round(($payment['total_revenue'] / $totalRevenue) * 100, 2) ?? 0,
                ];

            }
        }

        return [
            'user' => $user,
            'defaultAddress' => $defaultAddress,
            'accountCreatedAt' => $accountCreatedAt ? Carbon::parse($accountCreatedAt->created_at)->diffForHumans() : null,
            'countOrder' => $countOrder, // Vẫn giữ nguyên nếu bạn muốn hiển thị tổng số đơn hàng theo cách cũ

            'order' => $order,
            'percentCountSuccess' => $percentCountSuccess, //tính phần trăm số lượng đơn thành công
            'totalRevenue' => $totalRevenue,

            'successFullRevenue' => $successFullRevenue,
            'cancelledRevenue' => $cancelledRevenue,
            'refundRevenue' => $refundRevenue,
            'percentPriceSuccess' => $percentPriceSuccess ?? 0, //tính phần trăm doanh thu đơn thành công

            'orderDetails' => $orderDetails,
            'paymentMethodData' => $paymentMethodData,
            // 'listUserOrders' => $listUserOrders,
            // 'orderStatuses' => $orderStatuses,
        ];
    }

    public function getUserEmployee(Request $request, $limit)
    {
        return $this->userRepository->getUserEmployee($request, $limit);
    }

    public function countUserEmployeeLock()
    {
        return $this->userRepository->countUserEmployeeLock();
    }

    public function showUserEmployee(int $id, array $columns = ['*'])
    {
        return $this->userRepository->showUserEmployee($id, $columns);
    }
    public function getUserEmployeeLock(Request $request, $limit)
    {
        return $this->userRepository->getUserEmployeeLock($request, $limit);
    }
    public function createUserEmployee($data)
    {
        try {
            return $this->userRepository->create($data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }
    }

    public function UpdateUserEmployee($ids, $data)
    {
        try {

            if (is_array($ids)) {
                return $this->userRepository->listByIds($ids, $data['status']);
            }

            return $this->userRepository->update($ids, $data);
        } catch (\Throwable $th) {
            Log::error($th);
            return false;
        }

    }
}
