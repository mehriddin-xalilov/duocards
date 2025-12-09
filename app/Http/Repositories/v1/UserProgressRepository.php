<?php

namespace App\Http\Repositories\v1;


use App\Models\UserProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class UserProgressRepository
{
    use QueryBuilderTrait;
    /**
     * @var UserProgress $ modelClass
     */
    protected mixed $modelClass = UserProgress::class;

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

    public function show(Request $request, UserProgress $userProgress): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $userProgress);
        return okResponse($userProgress);
    }

    public function store(Request $request): JsonResponse
    {
        $model = UserProgress::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, UserProgress $userProgress): JsonResponse
    {
        $userProgress->update($request->all());
        $this->allowIncludeAndAppend($request, $userProgress);
        return okResponse($userProgress);
    }

    public function destroy(UserProgress $userProgress): JsonResponse
    {
        $userProgress->delete();
        return okResponse($userProgress);
    }
}

