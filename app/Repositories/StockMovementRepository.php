<?php

namespace App\Repositories;

use App\Models\StockMovement;

class StockMovementRepository extends BaseRepository {
    
    public function getModel()
    {
        return StockMovement::class;
    }
    
    public function getLatestId()
    {
        return $this->model->orderBy('id', 'desc')->limit(1)->value('id') ?? 0;
    }

    public function pagination(
        array $columns = ['*'],
        int $perPage = 15,
        array $orderBy = ['created_at', 'DESC'],
        $stockMovementType = null,
        $keyWord = null,
        array $relations = [],
    ) {
        return $this->model->select($columns)
            ->with($relations)
            ->when($stockMovementType, function ($query) use ($stockMovementType) {
                $query->where('type', $stockMovementType);
            })
            ->when($keyWord, function ($query) use ($keyWord) {
                $query->where('code_number', 'LIKE', '%'. $keyWord .'%');
            })
            ->orderBy($orderBy[0], $orderBy[1])
            ->paginate($perPage)
            ->withQueryString();
    }
}