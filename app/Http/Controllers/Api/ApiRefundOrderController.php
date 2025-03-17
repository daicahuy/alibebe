<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiRefundOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        try {
            //code...

            $filters = $request->all();
            $page = $request->input('page', 1);
            $limit = $request->input('limit', 10);


            $queryListRefundOrder = Refund::query()
                ->with('order', 'user', 'refundItems')
                ->orderBy('created_at', 'desc');


            foreach ($filters as $key => $value) {
                if ($key == 'search' && isset($value)) {
                    $queryListRefundOrder->where(function ($query) use ($value) {
                        $query->whereHas('order', function ($q) use ($value) {
                            $q->where('code', 'LIKE', "%{$value}%");
                        })
                            ->orWhereHas('user', function ($q) use ($value) {
                                $q->where('fullname', 'LIKE', "%{$value}%")
                                    ->orWhere('phone_number', 'LIKE', "%{$value}%");
                            });
                    });
                }
            }

            $dataListRefundOrder = $queryListRefundOrder->paginate($limit, ['*'], 'page', $page);

            return response()->json([
                'refundOrders' => $dataListRefundOrder->items(),
                'totalPages' => $dataListRefundOrder->lastPage(),
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }

    }

    public function getDataOrderRefund($id)
    {
        try {

            $dataOrderRefund = Refund::query()->where('id', $id)->with('order', 'user', 'refundItems')->first();

            return response()->json(["status" => Response::HTTP_OK, "dataOrderRefund" => $dataOrderRefund]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $adminReason = $request->input('adminReason');
            $idRefund = $request->input('idRefund');

            if ($adminReason) {
                Refund::query()
                    ->where('id', $idRefund)
                    ->update(['admin_reason' => $adminReason, 'status' => 'rejected']);

                return response()->json([
                    "message" => "OK Admin Reason",
                    "status" => Response::HTTP_OK
                ]);

            } else {
                Refund::query()
                    ->where('id', $idRefund)
                    ->update(['status' => 'receiving']);

                return response()->json([
                    "message" => "OK Admin receiving",
                    "status" => Response::HTTP_OK
                ]);
            }



        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }


}
