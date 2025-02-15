<?php

namespace App\Services\Web\Client;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class HomeService 
{
    protected CategoryRepository $categoryRepo;
    protected ProductRepository $productRepository ;

    // Khởi tạo
    public function __construct(CategoryRepository $categoryRepo , ProductRepository $productRepository)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepository = $productRepository;
    }

    
    public function listCategory()  {
        return $this->categoryRepo->listCategory();
    }
    public function getTrendingProduct() {
        return  $this->productRepository->getTrendingProducts();
    }
    public function getBestSellerProductsToday()  {
        return $this->productRepository->getBestSellerProductsToday();
    }

    public function topCategoriesInWeek()  {
        return $this->categoryRepo->topCategoryInWeek();
    }

    public function getBestSellingProduct()  {
        return $this->productRepository->getBestSellingProducts();
    }
};