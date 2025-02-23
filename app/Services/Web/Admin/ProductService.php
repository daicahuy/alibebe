<?php

namespace App\Services\Web\Admin;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class ProductService
{

    protected ProductRepository $productRepo;
    protected CategoryRepository $categoryRepo;
    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepo)
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function getProducts($perPage)
    {

        $products = $this->productRepo->getProducts($perPage);
        // $products->getCollection()->each(function ($product) {
        //     $totalStock = $product->productStock ? $product->productStock->stock : 0;
        //     $product->stock = $totalStock;

        // });
        // dd($products);
        return $products;
    }

    public function getCategories()
    {
        $categories = $this->categoryRepo->getAllParentCate();
        // dd($categories);

        return $categories;
    }
}
