<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $userId = request('user_id');
            $notifi = Notification::where('user_id', $userId)
                ->with('coupon')
                ->latest('id')
                ->paginate(5);
            return response()->json($notifi);
        } catch (\Throwable $th) {
            Log::error("error : " . $th);
        }
    }

    public function show($id)
    {
        $notifi = Notification::find($id);

        if (!$notifi) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Thông báo không tồn tại!'
            ], 404);
        }

        $notifi->update(['read' => true]);

        return response()->json([
            'status'  => 'success',
            'data'    => $notifi
        ]);
    }


    public function delete($id)
    {
        $notifi = Notification::find($id);

        if (!$notifi) {
            return response()->json(['message' => 'Thông báo không tồn tại!'], 404);
        }

        $notifi->delete();

        return response()->json(['message' => 'Đã Xóa thông báo thành công!']);
    }
}
