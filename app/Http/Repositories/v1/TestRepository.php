<?php

namespace App\Http\Repositories\v1;


use App\Models\Test;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class TestRepository
{
    use QueryBuilderTrait;
    /**
     * @var Test $ modelClass
     */
    protected mixed $modelClass = Test::class;

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

    public function show(Request $request, Test $test): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $test);
        return okResponse($test);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Test::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, Test $test): JsonResponse
    {
        $test->update($request->all());
        $this->allowIncludeAndAppend($request, $test);
        return okResponse($test);
    }

    public function destroy(Test $test): JsonResponse
    {
        $test->delete();
        return okResponse($test);
    }
}

