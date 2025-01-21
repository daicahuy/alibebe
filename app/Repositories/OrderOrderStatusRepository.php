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
                foreach ($idOrder as $orderId) {
                    OrderOrderStatus::query()
                        ->where('order_id', $idOrder)
                        ->update(['order_status_id' => $idStatus]);
                    HistoryOrderStatus::create([
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

    public function changeNoteStatusOrder($idOrder, $note)
    {
        return DB::transaction(function () use ($idOrder, $note) {

            OrderOrderStatus::query()
                ->where('order_id', $idOrder)
                ->update(['note' => $note]);
            ;
            return true;

        });

    }

    public function getOrderOrderStatus($idOrder)
    {
        $query = OrderOrderStatus::query()->where('order_id', $idOrder);
        return $query->get();
    }
}