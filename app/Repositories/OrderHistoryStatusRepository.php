<?php

namespace App\Repositories;

use App\Models\HistoryOrderStatus;
use App\Models\Message;

class OrderHistoryStatusRepository extends BaseRepository
{

    public function getModel()
    {
        return HistoryOrderStatus::class;
    }

    public function getListStatusHistory($idOrder)
    {
        return HistoryOrderStatus::query()->where('order_id', $idOrder)->with(["user"])->orderBy('created_at', 'asc')->get();
    }

}