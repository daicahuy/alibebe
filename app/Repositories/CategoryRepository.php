<?php

namespace App\Repositories;

use App\Models\Category;
use App\Services\Web\Admin\CategoryService;

class CategoryRepository extends BaseRepository
{

    public function getModel()
    {
        return Category::class;
    }


    // Tự viết hàm truy vấn mới
    // list category gốc, (parent_id = NULL) và con nếu có, dành cho list có phân trang
    public function getAllCate()
    {
        return $this->model->whereNull('parent_id')->with('categories')->orderBy('updated_at', 'desc')->paginate(5);
    }


    // Lấy nguyên cateory gốc
    public function getParent()
    {
        return $this->model->whereNull('parent_id')->get();

    }


    // Lấy nguyên category con
    public function getChild($id)//show 
    {
        return $this->model->where('id', $id)->with('categories')->first();
    }


    // Lấy danh sách xóa mềm
    public function getTrash()
    {
        return $this->model->onlyTrashed()->orderBy('updated_at', 'desc')->paginate(5);
    }


    //Tìm danh mục đã bị xóa mềm findOrFailWithTrashed để ném lỗi nếu không tìm thấy: trả về instance của model
    public function findOrFailWithTrashed(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }


    //    Lấy 1 danh mục bao gồm cả child && products: true: lấy cả products, false: không lấy
    public function findWithChild(int $id, bool $loadProducts = true)
    {
        $query = $this->model->where('id', $id)->with('categories');
        if ($loadProducts) {
            $query->with('products');
        }
        return $query->first();
    }

    // Lấy danh sách cate + relattion 
    public function getBulkTrash($ids)
    {
        return $this->model->whereIn('id', $ids)->with('categories')->get();
    }
    //
    // Lấy danh mục đã xóa mềm theo mảng ids, nối với get(), delete(), update()
    public function getwithTrashIds(array $ids)
    {
        return $this->model->withTrashed()->whereIn('id', $ids);
    }
}