<?php

namespace App\Http\Repositories\v1;


use App\Models\UserTestAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class UserTestAnswerRepository
{
    use QueryBuilderTrait;
    /**
     * @var UserTestAnswer $ modelClass
     */
    protected mixed $modelClass = UserTestAnswer::class;

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

    public function show(Request $request, UserTestAnswer $userTestAnswer): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $userTestAnswer);
        return okResponse($userTestAnswer);
    }

    public function store(Request $request): JsonResponse
    {
        $model = UserTestAnswer::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, UserTestAnswer $userTestAnswer): JsonResponse
    {
        $userTestAnswer->update($request->all());
        $this->allowIncludeAndAppend($request, $userTestAnswer);
        return okResponse($userTestAnswer);
    }

    public function destroy(UserTestAnswer $userTestAnswer): JsonResponse
    {
        $userTestAnswer->delete();
        return okResponse($userTestAnswer);
    }
}

