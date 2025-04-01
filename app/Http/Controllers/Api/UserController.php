<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Repositories\ProductRepository;
use App\Services\Web\Admin\UserCustomerService;
use App\Services\Web\Client\HomeService;
use Illuminate\Support\Facades\Request;

class UserController extends ApiBaseController
{
    protected UserCustomerService $userCustomerService;

    public function __construct(UserCustomerService $userCustomerService)
    {
        $this->userCustomerService = $userCustomerService;
    }

    public function detailReview(Request $request, $productId, User $user)
    {
        dd($user);
        $userId = $request->query('userId');
        $product = Product::with([
            'reviews' => function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->with(['user', 'reviewMultimedia']);
            },
            'reviews.user',
            'reviews.reviewMultimedia'
        ])->findOrFail($productId);
        // dd($product->reviews);
        return response()->json($product->reviews);
    }
}