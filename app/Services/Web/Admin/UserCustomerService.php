<?php

namespace App\Services\Web\Admin;

use App\Models\UserAddress;
use App\Repositories\OrderRepository;
use App\Repositories\OrderStatusRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use App\Repositories\WishlistRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserCustomerService
{
    protected $userRepository;
    protected UserAddressRepository $userAddressRepo;
    protected OrderRepository $orderRepo;
    protected WishlistRepository $wishlistRepo;
    protected ReviewRepository $reviewRepo;
    protected OrderStatusRepository $orderStatusesReopo;
    protected WishlistRepository $wishlistRepository;


    public function __construct(
        UserRepository $userRepository,
        UserAddressRepository $userAddressRepo,
        OrderRepository $orderRepo,
        WishlistRepository $wishlistRepo,
        ReviewRepository $reviewRepo,
        OrderStatusRepository $orderStatusesReopo,
        WishlistRepository $wishlistRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userAddressRepo = $userAddressRepo;
        $this->orderRepo = $orderRepo;
        $this->wishlistRepo = $wishlistRepo;
        $this->reviewRepo = $reviewRepo;
        $this->orderStatusesReopo = $orderStatusesReopo;
        $this->wishlistRepository = $wishlistRepository;
    }

    public function getUserCustomer(Request $request, $limit)
    {
        return $this->userRepository->getUserCustomer($request, $limit);
    }


    public function showUserCustomer(int $id, array $columns = ['*'])
    {
        return $this->userRepository->showUserCustomer($id, $columns);
    }
    public function getUserCustomerLock(Request $request, $limit)
    {
        return $this->userRepository->getUserCustomerLock($request, $limit);
    }

    public function countUserCustomerLock()
    {
        return $this->userRepository->countUserCustomerLock();
    }

    public function UpdateUserCustomer($ids, $data)
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
    // customer detail

    public function detail($userId, $startDate = null, $endDate = null, $filterStatus)
    {
        // địa chỉ
        $user = $this->userRepository->getUserAndAddress($userId, ['id', 'phone_number', 'email', 'fullname', 'avatar', 'loyalty_points', 'role', 'status', 'created_at']);
        $defaultAddress = $user->addresses->where('is_default', 1)->first();

        // lịch sử hoạt động 
        $accountCreatedAt = $this->userRepository->getTimeActivity($userId);
        $lastOrderTime = $this->orderRepo->getTimeActivity($userId);
        $lastWishlistTime = $this->wishlistRepo->getTimeActivity($userId);
        $lastReviewTime = $this->reviewRepo->getTimeActivity($userId);

        // rank - số lượng đơn
        $userRank = $this->userRepository->getUserRank($user->loyalty_points);
        $countOrder = $this->orderRepo->countOrderByUserId($userId);

        //III báo cáo chi tiết

        //1. Tổng quan đơn hàng
        $order = $this->orderRepo->countOrderDetail($userId, $status = null, $startDate, $endDate);
        $orderSuccess = $order['countSuccessDetail']; // số lg đơn thành công
        $orderCance = $order['countCancelDetail'];
        $orderProcessing = $order['countProcessingDetail'];
        $orderRefund = $order['countRefundDetail'];
        $allOrders = $order['countAllDetail'];// tổng số đơn

        //2. Doanh số
        $successFullRevenue = $order['revenueSuccessDetail']; // doanh thu đơn thành công
        $cancelledRevenue = $order['revenueCancelDetail']; // doanh thu hủy
        $processingRevenue = $order['revenueProcessingDetail']; // doanh thu đang xử lý 
        $refundRevenue = $order['revenueRefundDetail']; // doanh thu hoàn hàng 
        $totalRevenue = $this->orderRepo->getTotalRevenue($userId, $startDate, $endDate); //tổng doanh thu


        // dd($totalRevenue);
        // tính phần trăm doanh thu và số lượng đơn thành công
        $percentCountSuccess = 0;
        $percentPriceSuccess = 0;
        if ($allOrders > 0) {
            $percentCountSuccess = round(($orderSuccess / $allOrders) * 100, 2);
            $percentCountCancel = round($order['countCancelDetail'] / $allOrders * 100, 2);
            $percentCountProcessing = round($order['countProcessingDetail'] / $allOrders * 100, 2);
            $percentCountRefund = round($order['countRefundDetail'] / $allOrders * 100, 2);

            $percentPriceSuccess = round($successFullRevenue / $totalRevenue * 100, 2);
            // if ($totalRevenue > 0) {

            // }

        }

        //3. Chi Tiết Đơn Hàng
        $orderDetails = [
            [
                'type' => 'Đã hoàn thành',
                'quantity' => $orderSuccess,
                'revenue' => $successFullRevenue,
                'percentCount' => $percentCountSuccess,
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
                'type' => 'Đang xử lý',
                'quantity' => $orderProcessing,
                'revenue' => $processingRevenue,
                'percentCount' => $percentCountProcessing ?? 0,
                'badge_class' => 'bg-warning',
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

        $paymentMethods = $this->orderRepo->getPaymentMethod($userId, $startDate, $endDate);
        $paymentMethodData = [];
        if ($allOrders > 0 && $totalRevenue > 0) {
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
        // lấy status

        $orderStatuses = $this->orderStatusesReopo->getNameStatus();


        // danh sách đơn hàng 

        $listUserOrders = $this->orderRepo->getUserOrder($userId, $filterStatus);
        $countUserOrders = $this->orderRepo->countUserOrderById($userId);
        // dd($orderStatuses);
        // wish list
        $wishlists = $this->wishlistRepository->getWishlistById($userId);
        $countWishLists = $this->wishlistRepository->countWishlistById($userId);

        // review

        $reviews = $this->reviewRepo->getReviewByUser($userId);
        $countReviews = $this->reviewRepo->countReviewById($userId);

        return [
            'user' => $user,
            'defaultAddress' => $defaultAddress,

            'accountCreatedAt' => $accountCreatedAt ? Carbon::parse($accountCreatedAt->created_at)->diffForHumans() : null,
            'lastOrderTime' => $lastOrderTime ? Carbon::parse($lastOrderTime->created_at)->diffForHumans() : null,
            'lastWishlistTime' => $lastWishlistTime ? Carbon::parse($lastWishlistTime->created_at)->diffForHumans() : null,
            'lastReviewTime' => $lastReviewTime ? Carbon::parse($lastReviewTime->created_at)->diffForHumans() : null,

            'userRank' => $userRank,
            'countOrder' => $countOrder,

            'order' => $order,
            'percentCountSuccess' => $percentCountSuccess, //tính phần trăm số lượng đơn thành công
            'totalRevenue' => $totalRevenue,

            'successFullRevenue' => $successFullRevenue,
            'cancelledRevenue' => $cancelledRevenue,
            'refundRevenue' => $refundRevenue,
            'percentPriceSuccess' => $percentPriceSuccess ?? 0, //tính phần trăm doanh thu đơn thành công

            'orderDetails' => $orderDetails,
            'paymentMethodData' => $paymentMethodData,
            'listUserOrders' => $listUserOrders,
            'orderStatuses' => $orderStatuses,
            'filterStatus' => $filterStatus,
            'wishlists' => $wishlists ?? null,
            'countWishLists' => $countWishLists ?? 0,
            'countUserOrders' => $countUserOrders ?? 0,
            'reviews' => $reviews ?? null,
            'countReviews' => $countReviews ?? 0,

        ];
    }

}
