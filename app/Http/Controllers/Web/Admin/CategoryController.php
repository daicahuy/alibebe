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
    public function index()
    {
        $listCategory = $this->categoryService->index();
        // dd($listCategory);
        return view('admin.pages.categories.list', $listCategory);
    }

    public function trash()
    {
        $listTrash = $this->categoryService->trash();
        // dd($listTrash); // Kiểm tra dữ liệu NHẬN ĐƯỢC từ service
        if (is_array($listTrash) && !$listTrash['success']) {
            return back()->with([
                'msg' => $listTrash['message'],
                'type' => 'danger'
            ]);
        }
        // dd($listTrash);

        return view('admin.pages.categories.trash', compact('listTrash'));
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

        if ($response['success']) {

            $listCategory = $this->categoryService->index();

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
        // $parent = $this->categoryService-> 
        // dd($edit);
        // dd(compact('edit'));

    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $response = $this->categoryService->update($category->id, $data);

        if ($response['success']) {

            $listCategory = $this->categoryService->index();

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

    public function restore(Request $request)
    {

    }

    public function delete(Category $category)
    {
        // dd($category);  
        $delete = $this->categoryService->delete($category->id);

        if ($delete['success']) {

            $listCategory = $this->categoryService->index();

            return redirect() // chuyển hướng url

                ->route('admin.categories.index', $listCategory)

                ->with([
                    'msg' => $delete['message'],
                    'type' => 'success'
                ]);


        } else {

            return back()->with([
                'msg' => $delete['message'],
                'type' => 'danger'
            ]);
        }
    }
    // Xoa cứng
    public function destroy($id)
    {
        $category = Category::withTrashed()->findOrFail($id); // Tìm cả bản ghi đã bị xóa mềm
        $destroy = $this->categoryService->destroy($category->id);

        if ($destroy['success']) {

            $listTrash = $this->categoryService->trash();
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

}
