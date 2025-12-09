<?php

namespace App\Http\Repositories\v1;


use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class CategoryRepository
{
    use QueryBuilderTrait;
    /**
     * @var Category $ modelClass
     */
    protected mixed $modelClass = Category::class;

    public function index(Request $request): JsonResponse
    {
        $query = $this->defaultQuery($request);
        $this->defaultAllowFilter($query, $request);
        return $this->withPagination($query, $request);
    }

    public function adminIndex(Request $request): JsonResponse
    {
        $query = $this->defaultQuery($request);
        $this->defaultAllowFilter($query, $request);
        return $this->withPagination($query, $request);
    }

    public function show(Request $request, Category $category): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $category);
        return okResponse($category);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Category::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $category->update($request->all());
        $this->allowIncludeAndAppend($request, $category);
        return okResponse($category);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return okResponse($category);
    }
}

