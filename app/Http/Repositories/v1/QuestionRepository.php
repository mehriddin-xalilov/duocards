<?php

namespace App\Http\Repositories\v1;


use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class QuestionRepository
{
    use QueryBuilderTrait;
    /**
     * @var Question $ modelClass
     */
    protected mixed $modelClass = Question::class;

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

    public function show(Request $request, Question $question): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $question);
        return okResponse($question);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Question::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, Question $question): JsonResponse
    {
        $question->update($request->all());
        $this->allowIncludeAndAppend($request, $question);
        return okResponse($question);
    }

    public function destroy(Question $question): JsonResponse
    {
        $question->delete();
        return okResponse($question);
    }
}

