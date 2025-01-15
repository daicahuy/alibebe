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
    public function getAllCate()//list category gốc, (parent_id = NULL) và con nếu có, dành cho list có phân trang
    {
        return $this->model->whereNull('parent_id')->with('categories')->paginate(5);
    }
    public function getParent()
    {
        return $this->model->whereNull('parent_id')->get();

    }
    public function getChild($id)//show 
    {
        return $this->model->where('id', $id)->with('categories')->first();
    }

    public function getTrash()
    {
        return $this->model->onlyTrashed()->paginate(5);
    }

    public function deleteM($id)
    {
        return $this->model->where('id', $id)->delete();
    }
    public function forceDeleteM(int $id)
    {
        return $this->model->where('id', $id)->forceDelete();
    }
}