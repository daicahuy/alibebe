<?php

namespace App\Repositories;

use App\Models\Category;
use App\Services\Web\Admin\CategoryService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository
{

    public function getModel()
    {
        return Category::class;
    }

    // Tự viết hàm truy vấn mới
    public function getCategories($perPage = 15, $keyword = null, )
    {
        $query = $this->model->query();

        $query->select(
            'id',
            'icon',
            'name',
            'is_active',
            'created_at',
            'updated_at',
        )
            ->with(['categories'])
            ->where(['deleted_at' => null, 'is_active' => 1])
            ->whereNull('parent_id')
            ->orderBy('updated_at', 'DESC');






        // search
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%') // Tìm kiếm trong danh mục cha
                    ->orWhereHas('categories', function ($childCategoryQuery) use ($keyword) { // Tìm kiếm trong danh mục con
                        $childCategoryQuery->where('name', 'LIKE', '%' . $keyword . '%');
                    });
            });
        }



        $categories = $query->paginate($perPage)->appends([
            'per_page' => $perPage,
            '_keyword' => $keyword,
        ]);



        // dd($categories);

        return $categories;
    }
   

    public function getAllCate()
    {
        return $this->model->whereNull('parent_id')->with('categories')->orderBy('updated_at', 'desc')->paginate(5);
    }


    // Lấy nguyên cateory gốc
    public function getParent()
    {
        return $this->model->whereNull('parent_id')->get();
    }

    public function getParentActive(int $isActive = 1)
    {
        return $this->model->whereNull('parent_id')->where('is_active', $isActive)->get();
    }


    // Lấy nguyên category con
    public function getChild($id)//show 
    {
        return $this->model->with('categories')->find($id);
    }


    // Lấy danh sách xóa mềm
    public function getTrash($perPage = 15, $keyword = null)
    {
        $query = $this->model->onlyTrashed()->orderBy('updated_at', 'desc');
        if ($keyword) {
            $query->withTrashed()->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('categories', function ($childCategoryQuery) use ($keyword) {
                        $childCategoryQuery->withTrashed()->where('name', 'LIKE', '%' . $keyword . '%');
                    });
            });
        }
        return $query->paginate($perPage);
    }

    // Lấy danh sách hidden
    public function getHidden($perPage = 15, $keyword = null)
    {
        $query = $this->model->where('is_active', 0)->orderBy('updated_at', 'desc');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhereHas('categories', function ($childCategoryQuery) use ($keyword) {
                        $childCategoryQuery->where('name', 'LIKE', '%' . $keyword . '%');
                    });
            });
        }
        return $query->paginate($perPage);
    }


    //Tìm danh mục đã bị xóa mềm findOrFailWithTrashed để ném lỗi nếu không tìm thấy: trả về instance của model
    public function findOrFailWithTrashed(int $id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }


    //    Lấy 1 danh mục bao gồm cả child && (products: true: lấy cả products, false: không lấy)
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

    // Lấy danh mục con (child)
    // public function getChild
    // update child isactive
    public function updateChildIsactive($ids, $isActive)
    {
        return $this->model->whereIn('id', $ids)->update(['is_active' => $isActive]);
    }

    public function whereIn($ids)
    {
        return $this->model->whereIn('id', $ids);
    }

    // Đếm trash
    public function countTrash()
    {
        return $this->model->onlyTrashed()->count();
    }

    // đếm hidden
    public function countHidden()
    {
        return $this->model->where('is_active', 0)->count();
    }

    // restore
    public function update(int $id, array $data = [])
    {
        $category = $this->model->withTrashed()->find($id); // Tìm cả bản ghi đã xóa mềm

        if (!$category) {
            return false; // Hoặc throw exception nếu muốn xử lý lỗi ở service
        }

        $category->restore();//deleted_at => null

        $category->update($data);
        return $category;
    }
    // Client

    // Lấy danh sách category gồm name, icon, id
    public function getAllParentCate()
    {
        $category = $this->model
            ->whereNull('parent_id')
            ->where('is_active', 1)
            ->orderBy('id', 'ASC') //orinal
            ->select('id', 'name', 'icon')
            ->with('categories')
            // ->withCount([

            //     'childProductsCount AS child_products_count' => function ($query) {
            //         $query->whereHas('categories', function ($q) {
            //             $q->where('categories.is_active', 1);
            //         });

            //     }
            // ])
            ->withCount('products') //đếm cha
            ->get();
        // dd($category);
        return $category;
    }


    //  Home 
    public function listCategory()
    {
        $parentCategory = Category::whereNull('parent_id')->get();
        return $parentCategory;
    }

    public function topCategoryInWeek()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->join('categories', 'category_product.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->whereNull('parent_id')
            ->select(
                'categories.id',
                'categories.name',
                'categories.icon',
                DB::raw('COUNT(order_items.id) as total_sales')
            )
            ->groupBy('categories.id', 'categories.name', 'categories.icon')
            ->orderByDesc('total_sales')
            ->get();
    }

}
