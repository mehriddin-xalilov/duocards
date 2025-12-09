<?php

namespace App\Http\Repositories\v1;


use App\Models\UserAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class UserAnswerRepository
{
    use QueryBuilderTrait;
    /**
     * @var UserAnswer $ modelClass
     */
    protected mixed $modelClass = UserAnswer::class;

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

    public function show(Request $request, UserAnswer $userAnswer): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $userAnswer);
        return okResponse($userAnswer);
    }

    public function store(Request $request): JsonResponse
    {
        $model = UserAnswer::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, UserAnswer $userAnswer): JsonResponse
    {
        $userAnswer->update($request->all());
        $this->allowIncludeAndAppend($request, $userAnswer);
        return okResponse($userAnswer);
    }

    public function destroy(UserAnswer $userAnswer): JsonResponse
    {
        $userAnswer->delete();
        return okResponse($userAnswer);
    }
}

