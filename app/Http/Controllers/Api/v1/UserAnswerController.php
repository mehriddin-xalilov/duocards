<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserAnswer\StoreUserAnswerRequest;
use App\Http\Requests\UserAnswer\UpdateUserAnswerRequest;
use App\Http\Repositories\v1\UserAnswerRepository;
use Illuminate\Http\JsonResponse;
use App\Models\UserAnswer;
/**
 * @group UserAnswer
 *
 */
class UserAnswerController extends Controller
{

    public function __construct(public UserAnswerRepository $userAnswerRepository)
    {
    }

    /**
    * UserAnswer Get all
    *
    * @response {
    {{response}}
    * }
    * @return JsonResponse
    */

    public function index(Request $request)
    {
        return $this->userAnswerRepository->index($request);
    }

    /**
    * UserAnswer adminIndex get All
    *
    * @response {
    {{response}}
    * }
    * @return JsonResponse
    */

    public function adminIndex(Request $request)
    {
        return $this->userAnswerRepository->adminIndex($request);
    }

    /**
    * UserAnswer view
    *
    * @queryParam id required
    *
    * @param Request $request
    * @param int     $id
    * @return JsonResponse
    * @response {
    {{response}}
    * }
    */

    public function show(Request $request, UserAnswer $userAnswer): JsonResponse
    {
        return $this->userAnswerRepository->show($request, $userAnswer);
    }

    /**
    * UserAnswer create
    *
         * @bodyParam user_id integer
     * @bodyParam question_id integer
     * @bodyParam answer_id integer
     * @bodyParam is_correct boolean

    *
    * @param StoreUserAnswerRequest $request
    * @return JsonResponse
    */

    public function store(StoreUserAnswerRequest $request): JsonResponse
    {
        return $this->userAnswerRepository->store($request);
    }

    /**
    * UserAnswer update
    *
    * @queryParam userAnswer required
    *
         * @bodyParam user_id integer
     * @bodyParam question_id integer
     * @bodyParam answer_id integer
     * @bodyParam is_correct boolean

    *
    * @param UpdateUserAnswerRequest $request
    * @param UserAnswer $userAnswer
    * @return JsonResponse
    */

    public function update(UpdateUserAnswerRequest $request, UserAnswer $userAnswer): JsonResponse
    {
         return $this->userAnswerRepository->update($request, $userAnswer);
    }

    /**
     * UserAnswer delete
     *
     * @queryParam userAnswer required
     *
     * @param UserAnswer $userAnswer
     * @return JsonResponse
     */

    public function destroy(UserAnswer $userAnswer): JsonResponse
    {
        return  $this->userAnswerRepository->destroy($userAnswer);
    }
}
