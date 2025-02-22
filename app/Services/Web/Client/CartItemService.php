<?php

namespace App\Services\Web\Client;

use App\Repositories\CartItemRepository;
use Illuminate\Support\Facades\Log;

class CartItemService
{
    protected CartItemRepository $cartItemRepository;

    // Khởi tạo
    public function __construct(CartItemRepository $cartItemRepository)
    {
        $this->cartItemRepository = $cartItemRepository;
    }
    public function getAllCartItem()
    {
        try {
            return $this->cartItemRepository->getAllCartItem();
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
        }
    }

    public function addToCart($data)
    {
        try {
            return $this->cartItemRepository->addToCart($data);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
        }
    }

    public function delete(int $id)
    {
        try {
            return $this->cartItemRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            throw $th;
        }
    }

    public function deleteAll(array $ids)
    {
        try {
            return $this->cartItemRepository->deleteAll($ids);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            throw $th;
        }
    }
}
