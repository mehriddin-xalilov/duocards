<?php

namespace App\Http\Repositories\v1;


use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class AnswerRepository
{
    use QueryBuilderTrait;
    /**
     * @var Answer $ modelClass
     */
    protected mixed $modelClass = Answer::class;

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

    public function show(Request $request, Answer $answer): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $answer);
        return okResponse($answer);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Answer::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, Answer $answer): JsonResponse
    {
        $answer->update($request->all());
        $this->allowIncludeAndAppend($request, $answer);
        return okResponse($answer);
    }

    public function destroy(Answer $answer): JsonResponse
    {
        $answer->delete();
        return okResponse($answer);
    }
}

