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

            $findId = $this->categoryRepo->findWithChild($id, false); //false  => không load product
            // dd($findId);
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

            $this->categoryRepo->update($id, $data);

            // Nếu không upload ảnh mới thì anh cũ sẽ không bị xóa
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

            $findId = $this->categoryRepo->findWithChild($id);//true

            // dd($findId);

            if (!$findId) {

                return ['success' => false, 'message' => 'Danh mục không tồn tại'];

            } elseif ($findId->categories->isNotEmpty()) {

                return ['success' => false, 'message' => 'Danh mục này có danh mục con, không thể xóa'];

            } elseif ($findId->products->isNotEmpty()) {

                return ['success' => false, 'message' => 'Danh mục này có sản phẩm, không thể xóa'];

            }

            $delte = $findId->delete();

            if ($delte) {

                $findId->is_active = 0;

                $findId->save();

                return ['success' => true, 'message' => 'Xóa mềm thành công'];
            }

        } catch (\Throwable $th) {

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

            // hàm findById thông thường không tim bản ghi đã xóa mềm
            $findId = $this->categoryRepo->findOrFailWithTrashed($id);

            if (!$findId) {
                return ['success' => false, 'message' => 'Danh mục không tồn tại'];
            }

            $imageOld = $findId->icon; // lấy đường dẫn ảnh cũ

            $destroy = $findId->forceDelete();

            if ($destroy) {

                if (!empty($imageOld) && Storage::exists($imageOld)) {
                    Storage::delete($imageOld);
                }

                return ['success' => true, 'message' => 'Xóa vĩnh viễn thành công'];

            }



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

    public function restore($id)
    {
        try {

            $data = $this->categoryRepo->findOrFailWithTrashed($id); //trả về instance của model

            if (empty($data)) {
                return ['success' => false, 'message' => 'Danh mục không tồn tại'];
            }

            $data->is_active = 1;
            $data->deleted_at = null;
            $restore = $data->save();
            // dd(compact('data'));

            // $restore = $this->categoryRepo->update($id, $data);
            if ($restore) {
                return ['success' => true, 'message' => 'Khôi phục thành công'];
            }

        } catch (\Throwable $th) {

            Log::error(
                __CLASS__ . '--@--' . __FUNCTION__,
                ['error' => $th->getMessage()]
            );

            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau'];
        }
    }

    // Xử lý hàng loạt

    // Trang trash (xóa cứng, khôi phục)
    public function bulkDestroy($ids)
    {
        // dd($ids);
        if (!$ids || !is_array($ids) || empty($ids)) {
            return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một mục.'];
        }

        $failedIds = [];
        $successIds = [];
        try {
            foreach ($ids as $id) {
                try {
                    $category = Category::withTrashed()->find($id);
                    if (!$category) {
                        $failedIds[] = $id;
                        continue;
                    }

                    $imageOld = $category->icon;
                    if ($category->forceDelete()) {
                        if ($imageOld && Storage::exists($imageOld)) {
                            Storage::delete($imageOld);
                        }
                        $successIds[] = $id;
                    } else {
                        $failedIds[] = $id;
                    }
                } catch (\Throwable $th) {
                    Log::error(__METHOD__, ['error' => $th->getMessage(), 'id' => $id]);
                    $failedIds[] = $id;
                }
            }

            $message = '';
            $status = true;

            if (count($failedIds) > 0) {
                $message .= "Đã có lỗi xảy ra với các ID sau: " . implode(", ", $failedIds) . ". ";
                $status = false;
            }
            if (count($successIds) > 0) {
                $message .= "Đã xóa thành công các ID sau: " . implode(", ", $successIds) . ". ";
            }

            return ['success' => $status, 'message' => $message];

        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'ids' => $ids]);
            return ['success' => false, 'message' => 'Đã xảy ra lỗi tổng quan. Vui lòng thử lại sau.'];
        }
    }

    public function bulkRestore($ids)
    {
        if (!$ids || !is_array($ids) || empty($ids)) {
            return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một mục.'];
        }
        $failedIds = [];
        try {
            foreach ($ids as $id) {
                $category = Category::withTrashed()->find($id);
                if (!$category) {
                    $failedIds[] = $id;
                    continue;
                }
                if (!$this->restore($category->id)['success']) {
                    $failedIds[] = $id;
                }
            }
            if (count($failedIds) > 0) {
                $message = "Đã có lỗi xảy ra với các ID sau: " . implode(", ", $failedIds);
                $status = false;
            } else {
                $message = 'Đã khôi phục thành công các mục được chọn.';
                $status = true;
            }
            return ['success' => $status, 'message' => $message];
        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'ids' => $ids]);
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau.'];
        }
    }



    public function bulkTrash(array $categoryIds): array
{
    try {
        if (empty($categoryIds)) {
            return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một danh mục.'];
        }

        $successIds = [];
        $failedIds = [];

        foreach ($categoryIds as $categoryId) {
            try {
                $category = Category::find($categoryId);
                if ($category) {
                    $category->is_active = 0; // Đặt is_active thành false (xóa mềm)
                    $category->deleted_at = now(); // Đặt deleted_at thành thời gian hiện tại
                    $category->save();
                    $successIds[] = $categoryId;
                } else {
                    $failedIds[] = $categoryId;
                }
            } catch (\Throwable $th) {
                Log::error(__METHOD__, ['error' => $th->getMessage(), 'category_id' => $categoryId]);
                $failedIds[] = $categoryId;
            }
        }

        $message = '';
        $status = true;

        if (!empty($failedIds)) {
            $message .= "Đã có lỗi xảy ra với các ID: " . implode(", ", $failedIds) . ". ";
            $status = false;
        }
        if (!empty($successIds)) {
            $message .= "Đã chuyển vào thùng rác thành công các ID: " . implode(", ", $successIds) . ". ";
        }

        return ['success' => $status, 'message' => $message];

    } catch (\Throwable $th) {
        Log::error(__METHOD__, ['error' => $th->getMessage(), 'category_ids' => $categoryIds]);
        return ['success' => false, 'message' => 'Đã có lỗi tổng quan. Vui lòng thử lại sau.'];
    }
}
}
