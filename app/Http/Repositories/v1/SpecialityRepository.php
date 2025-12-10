<?php

namespace App\Http\Repositories\v1;


use App\Models\Speciality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\Traits\QueryBuilderTrait;

class SpecialityRepository
{
    use QueryBuilderTrait;
    /**
     * @var Speciality $ modelClass
     */
    protected mixed $modelClass = Speciality::class;

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

    public function show(Request $request, Speciality $speciality): JsonResponse
    {
        $this->allowIncludeAndAppend($request, $speciality);
        return okResponse($speciality);
    }

    public function store(Request $request): JsonResponse
    {
        $model = Speciality::query()->create($request->all());
        $this->allowIncludeAndAppend($request, $model);
        return okResponse($model);
    }

    public function update(Request $request, Speciality $speciality): JsonResponse
    {
        $speciality->update($request->all());
        $this->allowIncludeAndAppend($request, $speciality);
        return okResponse($speciality);
    }

    public function destroy(Speciality $speciality): JsonResponse
    {
        $speciality->delete();
        return okResponse($speciality);
    }
}

