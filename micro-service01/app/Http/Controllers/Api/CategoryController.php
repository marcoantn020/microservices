<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private Category $category
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CategoryResource::collection($this->category->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CategoryResource
     */
    public function store(CreateCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->category->create($data);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return CategoryResource
     */
    public function show(string $slug): CategoryResource
    {
        $category = $this->category->where('url','=',$slug)->firstOrFail();
        return new CategoryResource($category);
    }


    /**
     * @param UpdateCategoryRequest $request
     * @param string $slug
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, string $slug)
    {
        $category = $this->category->where('url','=',$slug)->firstOrFail();
        $data = $request->validated();
        $category->update($data);
        return response()->json(['message' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $slug)
    {
        $category = $this->category->where('url','=',$slug)->firstOrFail();
        $category->delete();
        return response()->json(null, 204);
    }
}
