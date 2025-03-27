<?php

namespace App\Services\Web\Admin;

use App\Repositories\StockMovementRepository;

class StockMovementService
{
    protected StockMovementRepository $stockMovementRepository;

    public function __construct(StockMovementRepository $stockMovementRepository)
    {
        $this->stockMovementRepository = $stockMovementRepository;
    }

    public function getList($perPage, $stockMovementType, $keyword)
    {
        return $this->stockMovementRepository->pagination(relations: ['user'], perPage: $perPage, stockMovementType: $stockMovementType, keyWord: $keyword);
    }
}