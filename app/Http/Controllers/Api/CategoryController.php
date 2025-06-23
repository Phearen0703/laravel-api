<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
public function index()
    {
        $categorys = Categorys::get();
        if($categorys->count() > 0){
                return CategoryResource::collection($categorys)
                    ->additional([
                        'message' => 'Categorys retrieved successfully',
                    ]);
        }else{
            return response()->json([
                'message' => 'No Categorys found',
            ], 200);
        }
    }
    public function show(Category $Category)
    {
        return new CategoryResource($Category);
        // Logic to retrieve and return a single Category by ID
        // return response()->json(['message' => 'Category retrieved successfully', 'data' => new CategoryResource($Category)], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All Fields are required',
                'errors' => $validator->messages(),
            ], 422);
        }

        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => 'Category created successfully',
            'data'=> new CategoryResource($Category)
        ], 200);
    }
    public function update(Request $request ,Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All Fields are required',
                'errors' => $validator->messages(),
            ], 422);
        }
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json([
            'message' => 'Category updated successfully',
            'data'=> new CategoryResource($category)
        ], 200);
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
