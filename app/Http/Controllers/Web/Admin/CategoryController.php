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


    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        // dd($perPage);
        // $perPage ?? 5;
        $listCategory = $this->categoryService->index($perPage);
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

            $listCategory = $this->categoryService->index(5);

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
        // $parent = $this->categoryService-> 
        // dd($edit);
        // dd(compact('edit'));

    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $response = $this->categoryService->update($category->id, $data);

        if ($response['success']) {

            $listCategory = $this->categoryService->index(5);

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

            $listTrash = $this->categoryService->trash();

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

            $listCategory = $this->categoryService->index(5);

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

    // xử lý hàng loạt

    // Xoá và khôi phục trong trash
    // Xử lý hàng loạt
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

    // Hàm chung để trả về response cho cả đơn và hàng loạt (redirect cho đơn, json cho hàng loạt)

    // private function handleResponse($response) {
    //     if ($response['success']) {
    //         return redirect()->route('admin.categories.trash')->with(['msg' => $response['message'], 'type' => 'success']);
    //     } else {
    //         return back()->with(['msg' => $response['message'], 'type' => 'danger']);
    //     }
    // }

    public function bulkTrash(Request $request)
    {


        $categoryIds = $request->input('category_ids');
        $response = $this->categoryService->bulkTrash($categoryIds);
        // dd($response);
        return response()->json($response);
    }
    //


    // search
    public function search(Request $request)
    {
        $keyword = $request->get('_keyword');
        $keyword = trim($keyword);
        $perPage = $request->input('per_page', 5);
        // if (empty($keyword)) {
        //     $listCategory = $this->categoryService->searchParent(null, $perPage);
        //     $mesage = null;
        // } else {
            $listCategory = $this->categoryService->search($keyword, $perPage);
            // if ($listCategory->isEmpty()) {
            //     $message = 'Không tìm thấy kết quả phù hợp.';
            // } else {
            //     $message = 'Tìm thấy kết quả.';
            // }
        // }
        // $listCategory = $this->categoryService->search($keyword, $perPage);
        // dd($listCategory);
        return view('admin.pages.categories.list', compact('listCategory', 'keyword'));


    }
}
