<?php

namespace App\Services\Web\Admin;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoryService
{
    // Gọi ra cate
    protected CategoryRepository $categoryRepo;
    // Khởi tạo
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }



    // List
    public function index()
    {
        try {
            $listCategory = $this->categoryRepo->getAllCate();

            // return $listCategory;
            return compact('listCategory');

        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }



    // Detail
    public function show($id)
    {
        try {
            $show = $this->categoryRepo->getChild($id);
            return compact('show');
            // return $show;


        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }

    // Edit

    public function edit($id)
    {
        try {

            $findId = $this->categoryRepo->findById($id);

            if (empty($findId)) {
                return ['success' => false, 'message' => 'Danh mục không tồn tại'];
            }

            $parentCate = $this->categoryRepo->getParent(); // lấy danh sách cha

            return ['success' => true, 'message' => 'Thêm mới thành công', 'findId' => $findId, 'parentCate' => $parentCate];
            // return compact('findId', 'parentCate');

        } catch (\Throwable $th) {

            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }


    // Update
    public function update($id, $data)
    {
        $data['ordinal'] ??= 0;
        $data['is_active'] ??= 0; //khi bỏ click => ko checked => ko gửi lên => mặc định là 0
        $data['slug'] = Str::slug($data['name']);

        try {


            if (!empty($data['icon'])) {
                $data['icon'] = Storage::put('categories', $data['icon']);
            }

            $imageOld = $this->categoryRepo->findById($id)->icon; // lấy đường dẫn ảnh cũ

            if (empty($data['icon'])) {
                $data['icon'] = $imageOld;
            }

            $this->categoryRepo->update($id, $data);

            if (!empty($data['icon']) && !empty($imageOld) && Storage::exists($imageOld)) {
                Storage::delete($imageOld);
            }
            return ['success' => true, 'message' => 'Cập nhật thành công'];

        } catch (\Throwable $th) {

            if (!empty($data['icon']) && Storage::exists($data['icon'])) {
                Storage::delete($data['icon']);
            }

            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }


    // Trash can
    public function trash()
    {
        try {

            $listTrash = $this->categoryRepo->getTrash();
            // dd($listTrash);
            // return compact('listTrash');
            return $listTrash;

        } catch (\Throwable $th) {

            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );

            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];

        }
    }



    // Create
    public function create()
    {
        // Hiện danh sách parent category

        try {
            $parent = $this->categoryRepo->getParent();
            return compact('parent');
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }


    // Store
    public function store($data)
    {

        $data['ordinal'] ??= 0;
        $data['is_active'] ??= 0; //khi bỏ click => ko checked => ko gửi lên => mặc định là 0
        $data['slug'] = Str::slug($data['name']);
        // $this->categoryRepo->create($data);



        try {
            if (!empty($data['icon'])) {
                $data['icon'] = Storage::put('categories', $data['icon']);
            }
            $this->categoryRepo->create($data);
            return ['success' => true, 'message' => 'Thêm mới thành công'];
        } catch (\Throwable $th) {
            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }

    public function delete($id)
    {
        try {

            $findId = $this->categoryRepo->findById($id);

            if (!$findId) {
                return ['success' => false, 'message' => 'Danh mục không tồn tại'];
            }

            $imageOld = $findId->icon; // lấy đường dẫn ảnh cũ

            // if (empty($findId['icon'])) {
            //     $findId['icon'] = $imageOld;
            // }


            $delete = $this->categoryRepo->deleteM($id);



            if ($delete) {
                // if (!empty($imageOld) && Storage::exists($imageOld)) {
                //     Storage::delete($imageOld);
                // }
                return ['success' => true, 'message' => 'Xóa thành công'];
            }

            // $parentCate = $this->categoryRepo->getParent(); // lấy danh sách cha

            return ['success' => false, 'message' => 'Xóa thất bại'];
            // return compact('findId', 'parentCate');

        } catch (\Throwable $th) {

            if (!empty($imageOld) && Storage::exists($imageOld)) {
                Storage::delete($imageOld);
            }

            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }

    public function destroy($id)
    {
        try {

            $findId = $this->categoryRepo->findOrFailWithTrashed($id);

            if (empty($findId)) {
                return ['success' => false, 'message' => 'Danh mục không tồn tại'];
            }

            $imageOld = $findId->icon; // lấy đường dẫn ảnh cũ




            $destroy = $this->categoryRepo->forceDeleteM($id);

            if ($destroy) {
                if (!empty($findId['icon']) && !empty($imageOld) && Storage::exists($imageOld)) {
                    Storage::delete($imageOld);
                }
                return ['success' => true, 'message' => 'Xóa thành công'];
            }

            // $parentCate = $this->categoryRepo->getParent(); // lấy danh sách cha

            return ['success' => true, 'message' => 'Xóa không thành công'];

            // return compact('findId', 'parentCate');

        } catch (\Throwable $th) {

            if (!empty($imageOld) && Storage::exists($imageOld)) {
                Storage::delete($imageOld);
            }

            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }

}
