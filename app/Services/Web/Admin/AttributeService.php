<?php

namespace App\Services\Web\Admin;

use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Repositories\AttributeRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AttributeService
{
    protected $attributeRepository;
    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function getAllAttributeService(Request $request, $filter = null)
    {
        try {
            $perpage = $request->input('perpage', 15);
            return $this->attributeRepository->getAllAttributeRepository($perpage, $filter);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
        }
    }

    public function store(StoreAttributeRequest $request)
    {
        try {
            $data = $request->validated();
            $data['slug'] = Str::slug($data['name'], '-');
            return $this->attributeRepository->create($data);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
        }
    }


    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {

        try {
            $data = $request->validated();
            $data['is_variant'] ??= 0;
            $data['is_active'] ??= 0;
            $data['slug'] = Str::slug($data['name'], '-');
            return $this->attributeRepository->update($attribute->id, $data);
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
            
            $data = $this->attributeRepository->findById($id);
            return $data->delete();
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            throw $th;
        }
    }
}
