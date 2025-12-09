<?php

namespace App\Http\Repositories\v1;


use App\Models\UserTestSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class UserTestSessionRepository
{
    use QueryBuilderTrait;
    /**
     * @var UserTestSession $ modelClass
     */
    protected mixed $modelClass = UserTestSession::class;

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

    public function show(Request $request, UserTestSession $userTestSession): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $userTestSession);
        return okResponse($userTestSession);
    }

    public function store(Request $request): JsonResponse
    {
        $model = UserTestSession::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, UserTestSession $userTestSession): JsonResponse
    {
        $userTestSession->update($request->all());
        $this->allowIncludeAndAppend($request, $userTestSession);
        return okResponse($userTestSession);
    }

    public function destroy(UserTestSession $userTestSession): JsonResponse
    {
        $userTestSession->delete();
        return okResponse($userTestSession);
    }
}

