<?php

namespace App\Services\Web\Admin;

use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use App\Models\AttributeValue;
use App\Repositories\AttributeValueRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class AttributeValueService
{
    protected $attributeValueRepository;
    public function __construct(AttributeValueRepository $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }
    
    public function getAllAttributeValue(Request $request, $attribute, $keyword = null){
        $perpage = $request->input('perpage', 15);
        $sortColumn = $request->input('sortColumn');
        $sortDirection = $request->input('sortDirection', 'desc');
        return $this->attributeValueRepository->getAllAttributeValueFindById($attribute,$perpage,$keyword,$sortColumn,$sortDirection);
    }

    public function store(StoreAttributeValueRequest $request, $attribute)
    {
        try {
            $data = $request->validated();
            $data['attribute_id'] = $attribute->id;
            // dd($data);
            return $this->attributeValueRepository->create($data);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
        }
    }


    public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue)
    {

        try {
            $data = $request->validated();
            $data['is_active'] ??= 0;
            // dd($data);
            return $this->attributeValueRepository->update($attributeValue->id, $data);
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
            return $this->attributeValueRepository->delete($id);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            throw $th;
        }
    }
    // public function deleteAll(array $ids)
    // {
    //     try {
    //         return $this->attributeRepository->deleteAll($ids);
    //     } catch (\Throwable $th) {
    //         Log::error(
    //             __CLASS__ . "@" . __FUNCTION__,
    //             ['error' => $th->getMessage()]
    //         );
    //         throw $th;
    //     }
    // }
}
