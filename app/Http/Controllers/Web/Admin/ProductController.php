<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Web\Admin\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index(Request $request)
    {

        $perPage = $request->get('per_page', 15);
        $categoryId = $request->get('category_id');
        $stockStatus = $request->get('stock_status');
        $keyword = $request->get('_keyword');
        // dd($categoryId);
        $productData = $this->productService->getProducts($perPage, $categoryId, $stockStatus, $keyword);
        $products = $productData['products'];
        $countTrash = $productData['countTrash'];
        $countHidden = $productData['countHidden'];
        $categories = $this->productService->getCategories();

        return view('admin.pages.products.list', compact(
            'products',
            'categories',
            'perPage',
            'categoryId',
            'stockStatus',
            'keyword',
            'countTrash',
            'countHidden'
        ));
    }

    public function trash(Request $request)
    {
        $perPage = $request->get('per_page');
        $keyword = $request->get('_keyword');

        $listTrashs = $this->productService->getTrash($perPage, $keyword);
        // dd($listTrashs);
        return view('admin.pages.products.trash', compact('listTrashs', 'perPage', 'keyword'));
    }

    public function hidden(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $keyword = $request->get('_keyword');


        $listHidden = $this->productService->getHidden($perPage, $keyword);
        // dd($listHidden);
        return view('admin.pages.products.hidden', compact(
            'listHidden',
            'perPage',
            'keyword'
        ));
    }

    public function show(string $slug)
    {
        $product = Product::query()->where('slug', $slug)->firstOrFail();

        $product->load(['categories', 'tags', 'productAccessories', 'productGallery', 'attributeValues', 'attributeValues.attribute', 'productStock']);

        if ($product->type === 1) {
            $product->load(['productVariants', 'productVariants.attributeValues', 'productVariants.attributeValues.attribute', 'productVariants.productStock']);
        }

        return view('admin.pages.products.show', ['product' => $product ,...$this->productService->getData()]);
    }

    public function create()
    {
        return view('admin.pages.products.create', $this->productService->getData());
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit(string $slug)
    {
        $product = Product::query()->where('slug', $slug)->firstOrFail();

        $product->load(['categories', 'tags', 'productAccessories', 'productGallery', 'attributeValues', 'attributeValues.attribute', 'productStock']);

        if ($product->type === 1) {
            $product->load(['productVariants', 'productVariants.attributeValues', 'productVariants.attributeValues.attribute', 'productVariants.productStock']);
        }

        return view('admin.pages.products.edit', ['product' => $product ,...$this->productService->getData()]);
    }

    public function update(Request $request, Product $product)
    {
        dd($request->all());
    }

    public function restore(Request $request, $product)
    {
        $restoreResult = $this->productService->restore($product);
        if ($restoreResult['success']) {
            return redirect()
                ->route('admin.products.trash')
                ->with([
                    'msg' => $restoreResult['message'],
                    'type' => 'success'
                ]);
        } else {
            return redirect()
                ->route('admin.products.trash')
                ->with([
                    'msg' => $restoreResult['message'],
                    'type' => 'error'
                ]);
        }

    }

    public function delete(Request $request, $product)
    {
        // dd($product);
        $deleteResult = $this->productService->delete($product);
        if ($deleteResult['success']) {
            return
                redirect()
                    ->route('admin.products.index')
                    ->with([
                        'msg' => $deleteResult['message'],
                        'type' => 'success'
                    ]);
        } else {
            return redirect()->route('admin.products.index')->with([
                'msg' => $deleteResult['message'],
                'type' => 'error'
            ]);
        }
    }

    public function destroy(Request $request, $product)
    {
        $response = $this->productService->forceDeleteProduct($product);
        if ($response['success']) {
            return
                redirect()
                    ->route('admin.products.trash')
                    ->with([
                        'msg' => $response['message'],
                        'type' => 'success'
                    ]);
        } else {
            return redirect()->route('admin.products.trash')->with([
                'msg' => $response['message'],
                'type' => 'error'
            ]);
        }
    }

    // xóa mềm nhiều 
    public function bulkTrash(Request $request)
    {
        $productIds = $request->input('product_ids');
        $response = $this->productService->bulkTrash($productIds);
        return response()->json($response);
    }

    // Khôi phục nhiều
    public function bulkRestore(Request $request)
    {
        $productIds = $request->input('bulk_ids');
        $response = $this->productService->bulkRestoreTrash($productIds);

        return response()->json($response);
    }

    // Xóa cứng nhiều 
    public function bulkDestroy(Request $request)
    {
        $productIds = $request->input('bulk_ids');
        $response = $this->productService->bulkFoceDeleteTrash($productIds);

        return response()->json($response);
    }


}
