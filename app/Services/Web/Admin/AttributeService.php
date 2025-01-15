<?php

namespace App\Services\Web\Admin;

use App\Http\Requests\CreateAttributeRequest;
use App\Repositories\AttributeRepository;
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
    public function getAllAttributeService(){
        return $this->attributeRepository->getAllAttributeRepository();
    }
    public function store(CreateAttributeRequest $request){
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

   

    public function update($request){
        $data = $request->validate([
            'name'      => ['required','max:255',Rule::unique('attributes')],
            'is_variant' => ['nullable',Rule::in(0,1)],
            'is_active' => ['nullable',Rule::in(0,1)],
        ]);
        $data['slug'] = Str::slug($data['name'], '-');
        return $this->attributeRepository->create($data);
    }
}
