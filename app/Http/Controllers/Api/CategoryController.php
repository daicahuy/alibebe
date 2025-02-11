<?php

namespace App\Http\Controllers\Api;

use ApiBaseController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Web\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // protected ApiBaseController $apiBaseController;
    // public function __construct(ApiBaseController $apiBaseController)
    // {
    //     $this->apiBaseController = $apiBaseController;
    // }
    /**
     * Display a listing of the resource.
     */
    public function toggleActive(Request $request, Category $category)
    {
        $isActive = $request->input('is_active'); // Nhận giá trị is_active từ request

    $category->is_active = $isActive; // Gán giá trị cho thuộc tính is_active
    $category->save(); // Lưu thay đổi

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công',
            'is_active' => $category->is_active,
            'category_id' => $category->id
        ]);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
