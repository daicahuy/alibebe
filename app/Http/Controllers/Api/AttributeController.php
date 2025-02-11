<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        try {
            $data = $request->all();
    
            // Nếu chỉ cần cập nhật `is_active`
            if ($request->has('is_active')) {
                $attribute->is_active = $data['is_active'];
                $attribute->save();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công.',
                'is_active' => $attribute->is_active,
            ]);
        } catch (\Throwable $th) {
            Log::error(__CLASS__ . "@" . __FUNCTION__, ['error' => $th->getMessage()]);
    
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật thất bại.',
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
