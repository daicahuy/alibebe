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



    // List
    public function index($perPage)
    {
        // dd($perPage);
        try {
            $perPage ?? 5;
            $listCategory = $this->categoryRepo->paginationM(
                ['*'],
                'parent_id',
                $perPage,
                ['updated_at', 'DESC'],
                ['categories']
            );

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

            // $data->is_active = 1;
            // $data->deleted_at = null;
            // $restore = $data->save();
            $restore = $this->categoryRepo->update($id, ['is_active' => 1, 'deleted_at' => null]);
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

            // Lấy danh sách cate + relation theo Ids
            $categoies = $this->categoryRepo->getBulkTrash($categoryIds);

            // check lỗi
            // $valiCate = [];

            foreach ($categoies as $category) {

                if ($category->categories->isNotEmpty()) {
                    $childrenIds[] = $category->id;

                } elseif ($category->products->isNotEmpty()) {
                    $productsIds[] = $category->id;

                } else {
                    $valiCate[] = $category->id;
                }
            }

            DB::beginTransaction();

            try {

                if (!empty($valiCate)) {

                    // Số lượng xóa success ko khớp với số lượng validate check

                    $deleteCount = $this->categoryRepo->getwithTrashIds($valiCate)->delete();

                    if ($deleteCount !== count($valiCate)) {

                        // lấy lại các id đã xóa mềm

                        $deletedids = $this->categoryRepo->getwithTrashIds($valiCate)
                            ->pluck('id') //chỉ lấy id
                            ->toArray(); //chuyển collection thành mảng

                        $successIds = $deletedids;

                        $failedIds = array_diff($valiCate, $successIds); // Lấy ra các phần tử không trùng nhau
                        Log::warning(
                            __METHOD__ . " - Số lượng category xóa không khớp",
                            [
                                'expected' => count($valiCate),
                                'actual' => $deleteCount,
                                'valid_category_ids' => $valiCate,
                                'success_ids' => $successIds,
                            ]
                        );

                    } else {
                        $successIds = $valiCate; //chiều thuận
                    }
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


            //    chuyển mảng => chuỗi,
            if (!empty($failedIds)) {
                $message .= "Đã có lỗi xảy ra với các ID: " . implode(", ", $failedIds) . '.' . PHP_EOL;
                $status = false;
            }

            if (!empty($childrenIds)) {
                $message .= "Có danh mục ở ID: " . implode(", ", $childrenIds) . '.' . PHP_EOL;
                $status = false;

            }

            if (!empty($productsIds)) {
                $message .= "Có sản phẩm ở ID: " . implode(", ", $productsIds) . '.' . PHP_EOL;
                $status = false;

            }

            if (!empty($successIds)) {
                $message .= "Đã chuyển vào thùng rác thành công  ID: " . implode(", ", $successIds) . '.';
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
    // search
    public function search($keyword, $perPage = null)
    {

        $perPageUse = $perPage ?? 5;
        $query = $this->categoryRepo->serach($keyword);
        $result = $query->paginate($perPageUse)->withQueryString();
        return $result;

        // if (empty($keyword)) {
        //     return [
        //         'success' => false,
        //         'message' => 'Vui lòng nhập tên danh mục',
        //         'listCategory' => $result,
        //         'keyword' => $keyword
        //     ];
        // }


        // if ($result) {
        //     return [
        //         'success' => true,
        //         'message' => 'Tìm thấy ' . count($result) . ' kết quả',
        //         'listCategory' => $result,
        //         'keyword' => $keyword
        //     ];
        // }
        // return [
        //     'success' => false,
        //     'message' => 'Không tìm thấy kết quả phù hợp',
        //     'listCategory' => $result,
        //     'keyword' => $keyword
        // ];


    }

    // public function searchParent(int $perPage = null, $parent = 'parent_id'): Paginator
    // {
    //     $perPageUse = $perPage ?? 5;
    //     return $this->categoryRepo->paginationM(
    //         ['*'],
    //         $parent,
    //         $perPage,
    //         ['updated_at', 'DESC'],
    //         ['categories']
    //     );
    // }

    // public function searchAll(int $perPage = null): Paginator
    // {
    //     $perPageUse = $perPage ?? 5;
    //     return $this->categoryRepo->paginationM(
    //         ['*'],
    //         null,
    //         $perPage,
    //         ['updated_at', 'DESC'],
    //         ['categories']
    //     );
    // }
    //
}
