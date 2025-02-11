<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttributeValueController extends Controller
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
    public function update(Request $request, Attribute $attribute, AttributeValue $attributeValue)
    {
        try {
            // Cập nhật trạng thái is_active
            $attributeValue->is_active = $request->input('is_active');
            $attributeValue->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công.',
                'is_active' => $attributeValue->is_active,
            ]);
        } catch (\Throwable $th) {
            // Ghi log lỗi và trả về lỗi
            Log::error($th->getMessage(), ['trace' => $th->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật trạng thái thất bại.',
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
