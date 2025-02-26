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
        $attributeSpecifications = $this->attributeRepository->getAllActive(['*'], ['attributeValues'], 0)->toArray();
        $attributeVariants = $this->attributeRepository->getAllActive(['*'], ['attributeValues'])->toArray();
        $newAttributeSpecifications = [];
        $newAttributeVariants = [];

        foreach ($attributeSpecifications as $attribute) {  
            $attributeName = $attribute['name'];
            $attributeValues = array_column($attribute['attribute_values'], 'value', 'id');
            
            $newAttributeSpecifications[$attributeName] = $attributeValues;
        }

        foreach ($attributeVariants as $attribute) {  
            $attributeName = $attribute['name'];
            $attributeValues = array_column($attribute['attribute_values'], 'value', 'id');
            
            $newAttributeVariants[$attributeName] = $attributeValues;
        }

        return [
            'tags' => $this->tagRepository->getAll(),
            'brands' => $this->brandRepository->getAllActive(),
            'categories' => $this->categoryRepository->getParentActive(),
            'productAccessories' => $this->productRepository->getAllActive(),
            'attributeSpecifications' => json_encode($newAttributeSpecifications),
            'attributeVariants' => json_encode($newAttributeVariants),
        ];
    }

    public function getProducts()
    {
        $products = $this->productRepository->getProducts();
        // $products->getCollection()->each(function ($product) {
        //     $totalStock = $product->productStock ? $product->productStock->stock : 0;
        //     $product->stock = $totalStock;
           
        // });
        // dd($products);
        return $products;
    }
}
