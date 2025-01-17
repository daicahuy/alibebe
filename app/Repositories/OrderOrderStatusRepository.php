<?php

namespace App\Repositories;

use App\Models\OrderOrderStatus;
use DB;

class OrderOrderStatusRepository extends BaseRepository
{

    public function getModel()
    {
        return OrderOrderStatus::class;
    }

    public function changeStatusOrder(int $idOrder, int $idStatus)
    {

        return DB::transaction(function () use ($idOrder, $idStatus) {
            OrderOrderStatus::query()
                ->where('order_id', $idOrder)
                ->update(['order_status_id' => $idStatus]);
            return true;
        });

    }
}