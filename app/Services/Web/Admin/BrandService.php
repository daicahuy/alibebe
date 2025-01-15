<?php

namespace App\Services\Web\Admin;

use App\Http\Requests\StoreBrandRequest;
use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandService
{
    protected $brandReponsitory;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandReponsitory = $brandRepository;
    }

    public function listBrand15BrandAsc() {
        return $this->brandReponsitory->pagination15BrandAsc();
    }
    public function StoreBrand(StoreBrandRequest $request )  {
        try {
            //code...
            $data = $request->validated();            
            if(isset($data['logo'])){
                $data['logo'] = Storage::put('brands',$data['logo']);
              
            } 
            $data['slug'] = str::slug($data['name']);

            // dd($data); // Kiểm tra dữ liệu đầy đủ trước khi gọi createBrand
            return $this->brandReponsitory->create($data);
                
           
        } catch (\Throwable $th) {
            //throw $th;
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            if(!empty($data['logo']) && Storage::exists($data['logo'])){
                 Storage::delete($data['logo']);   
            }
            throw $th;
        }
    }
}
