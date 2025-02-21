<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function getPaymentList()
    {
        try {

            $listPayment = Payment::query()->where("is_active", 1)->get();

            return response()->json(['status' => Response::HTTP_OK, 'listPayment' => $listPayment]);


        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'An error occurred: ' . $th->getMessage(),
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => [],
            ]);
        }
    }
}
