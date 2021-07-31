<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    use ApiResponse;
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->allProduct();
        return $this->successResponse(['products' => $products]);
    }

    public function store(ProductRequest $request)
    {

        if ($request->expectsJson()) {
            try {
                $this->productService->store($request->all(), $request);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse(['success' => true, 'message' => 'saved']);
        }
    }

    public function edit(Product $product)
    {
        return $this->successResponse(new ProductResource($product));
    }

    public function update(ProductRequest $request, Product $product)
    {

        if ($request->expectsJson()) {
            try {
                $this->productService->update($request->all(), $request, $product);
            } catch (\Exception $e) {
                return response()->json([
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);
            }
            return $this->successResponse(['success' => true, 'message' => 'updated']);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $this->productService->destroy($product);
        } catch (\Exception $e) {
            return response()->json([
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ]);
        }
        return $this->successResponse(['success' => true, 'message' => 'deleted']);
    }
}
