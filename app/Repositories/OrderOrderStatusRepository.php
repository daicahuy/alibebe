<?php

namespace App\Repositories;

use App\Models\HistoryOrderStatus;
use App\Models\OrderOrderStatus;
use DB;

class OrderOrderStatusRepository extends BaseRepository
{

    public function getModel()
    {
        return OrderOrderStatus::class;
    }

    public function changeStatusOrder($idOrder, int $idStatus)
    {
        return DB::transaction(function () use ($idOrder, $idStatus) {
            if (is_array($idOrder)) {
                OrderOrderStatus::query()
                    ->whereIn('order_id', $idOrder)
                    ->update(['order_status_id' => $idStatus]);
                foreach ($idOrder as $orderId) {
                    OrderOrderStatus::create([
                        'order_id' => $orderId,
                        'order_status_id' => $idStatus,
                    ]);
                }
                return true;

            } else {
                OrderOrderStatus::query()
                    ->where('order_id', $idOrder)
                    ->update(['order_status_id' => $idStatus]);
                HistoryOrderStatus::create([
                    'order_id' => $idOrder,
                    'order_status_id' => $idStatus,
                ]);
                return true;
            }
        });

    }

    public function getOrderOrderStatus($idOrder)
    {
        $query = OrderOrderStatus::query()->where('order_id', $idOrder);
        return $query->get();
    }
}