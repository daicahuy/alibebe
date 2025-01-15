<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository extends BaseRepository {
    
    public function getModel()
    {
        return Brand::class;
    }
    public function pagination15BrandAsc() {
        return Brand::orderBy('id','ASC')->paginate('5');
    }
   
    
  
}