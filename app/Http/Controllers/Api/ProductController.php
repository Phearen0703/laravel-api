<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        if($products->count() > 0){
                return ProductResource::collection($products)
                    ->additional([
                        'message' => 'Products retrieved successfully',
                    ]);
        }else{
            return response()->json([
                'message' => 'No products found',
            ], 200);
        }
    }
    public function show(Product $product)
    {
        return new ProductResource($product);
        // Logic to retrieve and return a single product by ID
        // return response()->json(['message' => 'Product retrieved successfully', 'data' => new ProductResource($product)], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id'=> 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All Fields are required',
                'errors' => $validator->messages(),
            ], 422);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);
        return response()->json([
            'message' => 'Product created successfully',
            'data'=> new ProductResource($product)
        ], 200);
    }
    public function update(Request $request ,Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id'=> 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All Fields are required',
                'errors' => $validator->messages(),
            ], 422);
        }
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);
        return response()->json([
            'message' => 'Product updated successfully',
            'data'=> new ProductResource($product)
        ], 200);
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
