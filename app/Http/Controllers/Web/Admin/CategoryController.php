<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Web\Admin\CategoryService;
use Illuminate\Http\Request;

use function Psy\debug;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    // làm lại 
    public function index(Request $request)
    {

        $perPage = $request->get('per_page', 15);
        $categoryId = $request->get('category_id');
        $stockStatus = $request->get('stock_status');
        $keyword = $request->get('_keyword');
        // dd($categoryId);
        $categoryData = $this->categoryService->getCategories($perPage, $keyword);
        $categories = $categoryData['categories'];
        $countTrash = $categoryData['countTrash'];
        $countHidden = $categoryData['countHidden'];
        // $categories = $this->categoryService->getCategories();

        return view('admin.pages.categories.list', compact(

            'categories',
            'perPage',
            'categoryId',
            'stockStatus',
            'keyword',
            'countTrash',
            'countHidden',
        ));
    }



    public function trash(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $keyword = $request->get('_keyword');

        $listTrash = $this->categoryService->trash($perPage, $keyword);

        // dd($listTrash); // Kiểm tra dữ liệu NHẬN ĐƯỢC từ service

        // dd($listTrash);

        return view('admin.pages.categories.trash', compact(
            'listTrash',
            'perPage',
            'keyword'
        ));
    }

    public function hidden(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $keyword = $request->get('_keyword');


        $listHidden = $this->categoryService->hidden($perPage, $keyword);
        // dd($listHidden);
        return view('admin.pages.categories.hidden', compact(
            'listHidden',
            'perPage',
            'keyword'
        ));
    }

    public function show(Category $category)
    {
        // dd($category->id);

        $show = $this->categoryService->show($category->id);
        // dd($show);

        return view('admin.pages.categories.show', $show);
    }

    public function create()
    {

        $parent = $this->categoryService->create();


        return view('admin.pages.categories.create', $parent);
    }

    public function store(StoreCategoryRequest $request)
    {

        // dd($_POST);
        $data = $request->validated();

        $response = $this->categoryService->store($data);
        $sortBy = $request->input('sort_by', 'updated_at'); // Cột mặc định để sắp xếp
        $order = $request->input('order', 'DESC'); // Hướng sắp xếp mặc định
        if ($response['success']) {

            $listCategory = $this->categoryService->getCategories(15, null);

            return redirect() // chuyển hướng url

                ->route('admin.categories.index', $listCategory)

                ->with([
                    'msg' => $response['message'],
                    'type' => 'success'
                ]);

        } else {

            return back()->with([
                'msg' => $response['message'],
                'type' => 'danger'
            ]);
        }

    }

    public function edit($id)
    {
        $edit = $this->categoryService->edit($id);
        // dd($edit);  
        if ($edit['success']) {

            return view('admin.pages.categories.edit', [

                'findId' => $edit['findId'],

                'parentCate' => $edit['parentCate']
            ]);


        } else {

            return back()->with([
                'msg' => $edit['message'],
                'type' => 'alert'
            ]);
        }

    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $perPage = $request->get('per_page', 15);

        $data = $request->validated();
        $response = $this->categoryService->update($category->id, $data);

        $sortBy = $request->input('sort_by', 'updated_at'); // Cột mặc định để sắp xếp
        $order = $request->input('order', 'DESC'); // Hướng sắp xếp mặc định
        if ($response['success']) {

            $listCategory = $this->categoryService->getCategories(15, null);

            return redirect() // chuyển hướng url

                ->route('admin.categories.index', $listCategory)

                ->with([
                    'msg' => $response['message'],
                    'type' => 'success'
                ]);

        } else {

            return back()->with([
                'msg' => $response['message'],
                'type' => 'danger'
            ]);

        }
    }

    public function restore($id)
    {
        $response = $this->categoryService->restore($id);

        if ($response['success']) {

            $listTrash = $this->categoryService->trash(15, null);

            return redirect() // chuyển hướng url

                ->route('admin.categories.trash', $listTrash)

                ->with([
                    'msg' => $response['message'],
                    'type' => 'success'
                ]);

        } else {

            return back()->with([
                'msg' => $response['message'],
                'type' => 'danger'
            ]);
        }
    }

    public function delete($id)
    {
        $response = $this->categoryService->delete($id);
        // dd($response);

        if ($response['success']) {

            $listCategory = $this->categoryService->getCategories(15, null);

            return redirect() // chuyển hướng url

                ->route('admin.categories.index', $listCategory)

                ->with([
                    'msg' => $response['message'],
                    'type' => 'success'
                ]);


        } else {

            return back()->with([
                'msg' => $response['message'],
                'type' => 'danger'
            ]);
        }
    }
    // Xoa cứng
    public function destroy($id)
    {
        // lưu ý Route Model Binding mặc định tìm bản ghi chưa xóa mềm, nên khi dùng sẽ bị 404

        // $category = Category::withTrashed()->findOrFail($id); // Tìm cả bản ghi đã bị xóa mềm

        $destroy = $this->categoryService->destroy($id);

        if ($destroy['success']) {

            $listTrash = $this->categoryService->trash(15, null);
            // dd($listTrash);
            // return view('admin.pages.categories.trash', $listTrash);

            return redirect() // chuyển hướng url

                ->route('admin.categories.trash', $listTrash)

                ->with([
                    'msg' => $destroy['message'],
                    'type' => 'success'
                ]);


        } else {

            return back()->with([
                'msg' => $destroy['message'],
                'type' => 'danger'
            ]);
        }
    }

    // xử lý hàng loạt

    // Xoá và khôi phục trong trash
    // Xóa nhiều
    public function bulkDestroy(Request $request)
    {
        // dd($request->input('bulk_ids')); 
        $response = $this->categoryService->bulkDestroy($request->input('bulk_ids'));
        return response()->json($response);
    }

    public function bulkRestore(Request $request)
    {
        $response = $this->categoryService->bulkRestore($request->input('bulk_ids'));
        return response()->json($response);
    }



    public function bulkTrash(Request $request)
    {


        $categoryIds = $request->input('category_ids');
        $response = $this->categoryService->bulkTrash($categoryIds);
        // dd($response);
        return response()->json($response);
    }
    //


  
}