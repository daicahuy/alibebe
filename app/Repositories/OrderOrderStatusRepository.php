<?php

namespace App\Repositories;

use App\Models\HistoryOrderStatus;
use App\Models\Order;
use App\Models\OrderOrderStatus;
use Auth;
use DB;

class OrderOrderStatusRepository extends BaseRepository
{

    public function getModel()
    {
        return OrderOrderStatus::class;
    }

    public function changeStatusOrder($idOrder, int $idStatus, $user_id)
    {

        return DB::transaction(function () use ($idOrder, $idStatus, $user_id) {
            if (is_array($idOrder)) {
                foreach ($idOrder as $orderId) {
                    OrderOrderStatus::query()
                        ->where('order_id', $orderId)
                        ->update(['order_status_id' => $idStatus, "modified_by" => $user_id]);
                    HistoryOrderStatus::create([
                        'order_id' => $orderId,
                        'order_status_id' => $idStatus,
                        'user_id' => $user_id
                    ]);
                }
                return true;

            } else {
                OrderOrderStatus::query()
                    ->where('order_id', $idOrder)
                    ->update(['order_status_id' => $idStatus, "modified_by" => $user_id]);
                HistoryOrderStatus::create([
                    'order_id' => $idOrder,
                    'order_status_id' => $idStatus,
                    'user_id' => $user_id

                ]);
                return true;
            }
        });

    }

    public function changeStatusOrderWithUserCheck($idOrder, $idStatus, $customerCheck)
    {
        if ($customerCheck == 0) {
            OrderOrderStatus::query()
                ->where('order_id', $idOrder)
                ->update(['customer_confirmation' => $customerCheck]);
        } else if ($customerCheck == 1) {
            OrderOrderStatus::query()
                ->where('order_id', $idOrder)
                ->update(['order_status_id' => $idStatus, "customer_confirmation" => $customerCheck]);
            HistoryOrderStatus::create([
                'order_id' => $idOrder,
                'order_status_id' => $idStatus,
            ]);
        }
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

    public function updateConfirmCustomer($note, $employee_evidence, $idOrder)
    {
        return DB::transaction(function () use ($idOrder, $note, $employee_evidence) {

            OrderOrderStatus::query()
                ->where('order_id', $idOrder)
                ->update(['note' => $note, 'employee_evidence' => $employee_evidence, "order_status_id" => 4]);
            ;

            HistoryOrderStatus::create([
                'order_id' => $idOrder,
                'order_status_id' => 4,
            ]);
            return true;

        });

    }

    public function getOrderOrderStatus($idOrder)
    {
        $query = OrderOrderStatus::query()->where('order_id', $idOrder);
        return $query->get();
    }
}