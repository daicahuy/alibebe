<?php

namespace App\Services\Web\Admin;

use App\Repositories\AttributeValueRepository;

class AttributeValueService
{
    protected $attributeValueRepository;
    public function __construct(AttributeValueRepository $attributeValueRepository)
    {
        $this->attributeValueRepository = $attributeValueRepository;
    }
    public function getAllAttributeValue($attribute){
        return $this->attributeValueRepository->getAllAttributeValueFindById($attribute);
    }
}
