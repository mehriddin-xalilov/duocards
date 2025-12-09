<?php

namespace App\Http\Repositories\v1;


use App\Models\Level;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class LevelRepository
{
    use QueryBuilderTrait;
    /**
     * @var Level $ modelClass
     */
    protected mixed $modelClass = Level::class;

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

    public function show(Request $request, Level $level): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $level);
        return okResponse($level);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Level::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, Level $level): JsonResponse
    {
        $level->update($request->all());
        $this->allowIncludeAndAppend($request, $level);
        return okResponse($level);
    }

    public function destroy(Level $level): JsonResponse
    {
        $level->delete();
        return okResponse($level);
    }
}

