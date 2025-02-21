<?php

namespace App\Services\Web\Admin;

use App\Repositories\AttributeRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TagRepository;

class ProductService
{
    protected TagRepository $tagRepository;
    protected BrandRepository $brandRepository;
    protected CategoryRepository $categoryRepository;
    protected ProductRepository $productRepository;
    protected AttributeRepository $attributeRepository;

    public function __construct(
        TagRepository $tagRepository,
        BrandRepository $brandRepository,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository,
        AttributeRepository $attributeRepository,
    ) {
        $this->tagRepository = $tagRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
    }

    public function getData()
    {
        $attributes = $this->attributeRepository->getAllActive(['*'], ['attributeValues'])->toArray();
        $newAttributes = [];

        foreach ($attributes as $attribute) {  
            $attributeName = $attribute['name'];
            $attributeValues = array_column($attribute['attribute_values'], 'value');
            
            $newAttributes[$attributeName] = $attributeValues;
        }

        return [
            'tags' => $this->tagRepository->getAll(),
            'brands' => $this->brandRepository->getAllActive(),
            'categories' => $this->categoryRepository->getParentActive(),
            'productAccessories' => $this->productRepository->getAllActive(),
            'attributes' => json_encode($newAttributes)
        ];
    }
}
