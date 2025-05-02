<?php

namespace App\Services\Web\Admin;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Event\Runtime\PHP;

class CategoryService
{
    // Gọi ra cate
    protected CategoryRepository $categoryRepo;

    // Khởi tạo
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;

    }
    // làm lại
    public function getCategories($perPage, $keyword)
    {


        $categories = $this->categoryRepo->getCategories($perPage, $keyword);





        $countTrash = $this->categoryRepo->countTrash();
        $countHidden = $this->categoryRepo->countHidden();


        // dd($categories);
        return [
            'categories' => $categories,
            'countTrash' => $countTrash,
            'countHidden' => $countHidden,
        ];
    }






    // Detail
    public function show($id)
    {
        try {

            $show = $this->categoryRepo->getChild($id);
            // dd($show);
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

            // dd($cateOld);
            $this->categoryRepo->update($id, $data);

            $ids = [];
            $childCate = $this->categoryRepo->getChild($id);
            foreach ($childCate->categories as $cate) {
                $ids[] = $cate->id;
            }
            // dd($ids);
            // dd($childCate);
            if ($data['is_active'] == 0 && !empty($childCate)) {
                $this->categoryRepo->whereIn($ids)->update(['is_active' => 0]);
            }

            if ($data['is_active'] == 1 && !empty($childCate)) {
                $this->categoryRepo->whereIn($ids)->update(['is_active' => 1]);
            }


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


    // Trash 
    public function trash($perPage, $keyword)
    {
        try {

            $listTrash = $this->categoryRepo->getTrash($perPage, $keyword);
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

    // Hiddent
    public function hidden($perPage, $keyword)
    {
        // dd($perPage);
        try {


            // dd($listHidden);

            $listHidden = $this->categoryRepo->getHidden($perPage, $keyword);
            // dd($listHidden);
            return $listHidden;

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
            // return response()->json(['message' => 'Thành công!', 'type' => 'success']);

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
            // dd($data);

            if (empty($data)) {
                return ['success' => false, 'message' => 'Danh mục không tồn tại'];
            }

            $restore = $this->categoryRepo->update($id, ['is_active' => 1]);
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

    // Xóa cứng,
    public function bulkDestroy($ids)
    {
        // dd($ids);
        if (!$ids || !is_array($ids) || empty($ids)) {
            return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một mục.'];
        }

        $failedIds = [];
        $successIds = [];
        DB::beginTransaction();
        try {

            // xóa image
            $categories = $this->categoryRepo->getwithTrashIds($ids)->get();

            foreach ($categories as $category) {
                $imageOld = $category->icon;
                if ($imageOld && Storage::exists($imageOld)) {
                    Storage::delete($imageOld);
                }
            }

            $deletedCount = $this->categoryRepo->getwithTrashIds($ids)->forceDelete();

            if ($deletedCount !== count($ids)) {

                $deletedIds = $this->categoryRepo->getwithTrashIds($ids)
                    ->pluck('id')->toArray();

                $failedIds = array_diff($ids, $deletedIds);

                Log::warning(
                    __METHOD__ . " - Số lượng category xóa không khớp",
                    [
                        'expected' => count($ids),
                        'actual' => $deletedCount,
                        'category_ids' => $ids,
                        'deleted_ids' => $deletedIds,
                        'failed_ids' => $failedIds,
                    ]
                );
            } else {
                $successIds = $ids;

            }
            DB::commit();


            return [
                'success' => true,
                'message' => 'Xóa thành công [' . $deletedCount . '] danh mục.',
                'restored_count' => $deletedCount,
            ];

        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'ids' => $ids]);
            return ['success' => false, 'message' => 'Đã xảy ra lỗi tổng quan. Vui lòng thử lại sau.'];
        }
    }

    // Khôi phục
    public function bulkRestore($categoryIds)
    {
        try {
            if (!$categoryIds || !is_array($categoryIds) || empty($categoryIds)) {
                return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một mục.'];
            }
            $failedIds = [];
            $successIds = [];
            DB::beginTransaction();
            try {
                $restoreCount = $this->categoryRepo->getwithTrashIds($categoryIds)
                    ->update(['is_active' => 1, 'deleted_at' => null]);

                DB::commit();


            } catch (\Throwable $innerError) {
                DB::rollBack();
                Log::error(
                    __METHOD__ . ' - Inner Transaction Error',
                    [
                        'error' => $innerError->getMessage(),
                        'category_ids' => $categoryIds,
                    ]
                );
                return [
                    'success' => false,
                    'message' => 'Đã có lỗi trong quá trình khôi phục. Vui lòng thử lại sau.',
                ];
            }

            return [
                'success' => true,
                'message' => 'Khôi phục thành công [' . $restoreCount . '] danh mục.',
                'restored_count' => $restoreCount,
            ];

        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'categoryIds' => $categoryIds]);
            return ['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau.'];
        }
    }


    // xoa mềm
    public function bulkTrash(array $categoryIds)
    {
        try {

            if (!$categoryIds || !is_array($categoryIds) || empty($categoryIds)) {
                return ['success' => false, 'message' => 'Vui lòng chọn ít nhất một mục.'];
            }

            $successIds = [];
            $failedIds = [];
            $childrenIds = [];
            $productsIds = [];
            $hasError = false;
            // Lấy danh sách cate + relation theo Ids
            $categoies = $this->categoryRepo->getBulkTrash($categoryIds);

            // check lỗi và ngắt vòng lặp nếu có lỗi
            foreach ($categoies as $category) {
                if ($category->categories->isNotEmpty() || $category->products->isNotEmpty()) {
                    $failedIds[] = $category->id;
                    $hasError = true;
                    break; // *** THAY ĐỔI: Ngắt vòng lặp ngay khi có lỗi ***
                } else {
                    $successIds[] = $category->id;
                }
            }

            DB::beginTransaction();

            try {

                if (!$hasError && !empty($successIds)) {

                    // Số lượng xóa success ko khớp với số lượng validate check

                    $deleteCount = $this->categoryRepo->getwithTrashIds($successIds)->delete();

                    // chuyển những tak đã xóa mềm thành false
                    $this->categoryRepo->getwithTrashIds($successIds)->update(['is_active' => 0]);

                    // $activeFalse

                    if ($deleteCount !== count($successIds)) {

                        // lấy lại các id đã xóa mềm

                        $deletedids = $this->categoryRepo->getwithTrashIds($successIds)
                            ->pluck('id') //chỉ lấy id
                            ->toArray(); //chuyển collection thành mảng

                        $successIds = $deletedids;

                        $failedIds = array_merge($failedIds, array_diff($successIds, $deletedids));
                        Log::warning(
                            __METHOD__ . " - Số lượng category xóa không khớp",
                            [
                                'expected' => count($successIds),
                                'actual' => $deleteCount,
                                'valid_category_ids' => $successIds,
                                'success_ids' => $successIds,
                            ]
                        );

                    }
                    // else {
                    //     $successIds = $valiCate; //chiều thuận
                    // }
                }

                DB::commit();
            } catch (\Throwable $innerError) {

                DB::rollBack();
                Log::error(
                    __METHOD__ . ' -Inner Transaction Error',
                    [
                        'error' => $innerError->getMessage(),
                        'category_ids' => $categoryIds
                    ]
                );
                throw $innerError; //ném exception ra try catch bên ngoài
            }


            $message = '';
            $status = true;

            if ($hasError) {
                $message = 'Một hoặc nhiều danh mục không thể xóa mềm do chứa SẢN PHẨM hoặc DANH MỤC CON.';
                $status = false;
            } else if (!empty($successIds)) {
                $message = "Đã xóa mềm thành công.";
            } else {
                $message = 'Không có danh mục nào được chuyển vào thùng rác.';
                $status = false; // Hoặc true nếu bạn muốn báo thành công (không có gì để xóa hợp lệ)
            }



            return [
                'success' => $status,
                'message' => nl2br($message), // Chuyển đổi newline  thành <br>
                'failed_ids' => $failedIds
            ];

        } catch (\Throwable $th) {
            Log::error(__METHOD__, ['error' => $th->getMessage(), 'category_ids' => $categoryIds]);
            return ['success' => false, 'message' => 'Đã có lỗi tổng quan. Vui lòng thử lại sau.'];
        }




    }





    // }


}
