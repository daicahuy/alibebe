<?php

namespace App\Services;

use App\Events\UserStatusChanged;
use App\Jobs\UnlockUsersJob;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use App\Models\UserOrderCancel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class OrderCancelService
{
    public function checkAndApplyPenalty(int $userId): JsonResponse|null
    {
        $cancels = UserOrderCancel::where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(3))
            ->count();

        if ($cancels >= 5) {
            return $this->applyPenalty($userId, $cancels);
        }
        return null;
    }

    private function applyPenalty(int $userId, int $cancels): JsonResponse|null
    {
        $user = User::find($userId);
        if (!$user) {
            return null; // Trả về null nếu không tìm thấy user
        }

        if ($cancels === 5 && $user->time_block_order === null) {
            $user->update([
                'order_blocked_until' => Carbon::now()->addDays(3),
                'C' => 1,
            ]);
            dispatch(new UnlockUsersJob($user->id))->delay(now()->addDays(3));
        } elseif ($cancels === 5 && $user->time_block_order === 1) {
            $user->update([
                'order_blocked_until' => Carbon::now()->addDays(5),
                'time_block_order' => 2,
            ]);
            dispatch(new UnlockUsersJob($user->id))->delay(now()->addDays(5));
        } elseif ($cancels >= 5 && $user->time_block_order === 2) {
            $user->update([
                'status' => 0,
                'time_block_order' => 3,
            ]);

            Auth::logout();

            return response()->json([
                'message' => 'Tài khoản của bạn đã bị khóa.',
                'should_logout' => true,
            ], 403);
        } elseif ($cancels >= 5 && $user->time_block_order >= 3) {
            $user->update([
                'status' => 0,
                'time_block_order' => $user->time_block_order + 1,
            ]);

            Auth::logout();

            return response()->json([
                'message' => 'Tài khoản của bạn đã bị khóa.',
                'should_logout' => true,
            ], 403);
        }

        return null; // Luôn return giá trị ở cuối hàm
    }
    public function delete(int $userId): void
    {
        UserOrderCancel::where('user_id', $userId)->delete();
    }
}
