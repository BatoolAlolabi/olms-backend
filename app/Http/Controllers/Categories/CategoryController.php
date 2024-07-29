<?php

namespace App\Http\Controllers\Categories;

use App\Domain\Categories\Actions\CreateCategoryAction;
use App\Domain\Categories\DTO\CategoryDTO;
use App\Domain\Categories\Actions\UpdateCategoryAction;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json(Response::success($categories->toArray()),200);
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
        $validator = Validator::make($request->all(),[
            'name' => ['required','string'],
            'description' => ['nullable','string'],
            'type' => ['string','nullable']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $categoryDTO = CategoryDTO::fromRequest($request->all());
        $category = CreateCategoryAction::execute($categoryDTO);
        return response()->json(Response::success($category->toArray()),200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required','string'],
            'description' => ['nullable','string'],
            'type' => ['string','nullable']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        $categoryDTO = CategoryDTO::fromRequest($request->all());
        $category = Category::query()->find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                    ], 404);
                }
        $category = UpdateCategoryAction::execute($category,$categoryDTO);
        return response()->json(Response::success($category->toArray()),200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $category = Category::query()->find($id);
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
                    ], 404);
                }
        $category->delete();
        return response()->json(Response::success($category->toArray()),200);
    }
}
