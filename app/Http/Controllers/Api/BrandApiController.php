<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateIsActiveRequest;
use App\Models\Brand;
use App\Services\Web\Admin\BrandService;
use Illuminate\Http\Request;

class BrandApiController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    /**
     * Display a listing of the resource.
     */
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
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIsActiveRequest $request, Brand $brand)
    {
        try {
            // Lấy trạng thái từ request
            $status = $request->status;

            // Gọi service để xử lý cập nhật trạng thái
            $result = $this->brandService->updateStatus($brand, $status);

            // Trả về phản hồi JSON
            return response()->json([
                'message' => $result['message'],
                'status' => $result['status'],
            ]);
        } catch (\Exception $e) {
            // Trả về lỗi
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
