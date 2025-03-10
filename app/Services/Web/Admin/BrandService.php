<?php

namespace App\Services\Web\Admin;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\UpdateIsActiveRequest;
use App\Models\Brand;
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

    public function listBrand15BrandAsc(int $perPage, string $keyWord = null , string $sort = null, string $order = null)
    {
        return $this->brandReponsitory->pagination15BrandAsc($perPage, $keyWord, $sort, $order);
    }
    public function listHidden(int $perPage, string $keyWord = null , string $sort = 'name', string $order = 'desc')
    {
        return $this->brandReponsitory->hiddenIsActive($perPage, $keyWord, $sort, $order);
    }

    public function getProductsByBrand($brandId) {
        return $this->brandReponsitory->getProductsByBrand($brandId);
    }
    public function StoreBrand(StoreBrandRequest $request)
    {
        try {
            //code...
            $data = $request->validated();
            if (isset($data['logo'])) {
                $data['logo'] = Storage::put('brands', $data['logo']);

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
            if (!empty($data['logo']) && Storage::exists($data['logo'])) {
                Storage::delete($data['logo']);
            }
            throw $th;
        }
    }
    public function updateStatus(Brand $brand, bool $status): array
    {
        try {
            Log::info("Updating Brand ID {$brand->id} status from {$brand->is_active} to {$status}");

            // Cập nhật trạng thái
            $brand->is_active = $status;
            $brand->save();

            return [
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
                'status' => $brand->is_active,
            ];
        } catch (\Throwable $th) {
            Log::error("Error updating Brand status", ['error' => $th->getMessage()]);
            throw new \Exception('Cập nhật trạng thái thất bại!');
        }
    }
    public function UpdateBrand(UpdateBrandRequest $request, Brand $brand)
    {
        $data = $request->validated();
        // dd($data);

        try {
            if (isset($data['logo'])) {
                $data['logo'] = Storage::put('brands', $data['logo']);
            }
            $currentLogo = $brand->logo;
            $data['slug'] = Str::slug($data['name']);
            if (
                $request->hasFile('logo')
                && !empty($currentLogo)
                && Storage::exists($data['logo'])
            ) {
                Storage::delete($currentLogo);
            }
            return $this->brandReponsitory->update($brand->id, $data);

        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            if (!empty($data['logo']) && Storage::exists($data['logo'])) {
                Storage::delete($data['logo']);
            }
        }
    }
    public function delete(int $id)
    {
        try {
            return $this->brandReponsitory->delete($id);
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . "@" . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            throw $th;
        }
    }

    public function deleteAll(array $ids)
    {
        try {

            return $this->brandReponsitory->deleteAll($ids);
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . "@" . __FUNCTION__, ['error' => $th->getMessage()]);
            throw $th; // Truyền tiếp lỗi lên Controller
        }
    }

}