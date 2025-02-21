<?php

namespace App\Services\Web\Admin;

use App\Repositories\ProductRepository;

class ProductService
{

    protected ProductRepository $productRepo;
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getProducts()
    {
        $products = $this->productRepo->getProducts();
        // $products->getCollection()->each(function ($product) {
        //     $totalStock = $product->productStock ? $product->productStock->stock : 0;
        //     $product->stock = $totalStock;
           
        // });
        // dd($products);
        return $products;
    }
}
