<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Services\TestSolvingService;
use Illuminate\Http\Request;

class TestSolvingController extends Controller
{
    protected $testSolvingService;

    public function __construct(TestSolvingService $testSolvingService)
    {
        $this->testSolvingService = $testSolvingService;
    }

    /**
     * Test ni boshlash
     */
    public function startTest(Request $request)
    {
        $request->validate([
            'test_id' => 'required|exists:tests,id',
        ]);

        try {
            $result = $this->testSolvingService->startTest(auth()->id(), $request->test_id);
            return okResponse($result, 201);
        } catch (\Exception $e) {
            return errorResponse(message: $e->getMessage(), status: 400);
        }
    }

    /**
     * Test savollarini olish
     */
    public function getTestQuestions(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:user_test_sessions,id',
        ]);
        try {
            $result = $this->testSolvingService->getTestQuestions($request->session_id);
            return okResponse($result);
        } catch (\Exception $e) {
            return errorResponse(message: $e->getMessage(), status: 400);
        }
    }

    /**
     * Javob saqlash
     */
    public function submitAnswer(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:user_test_sessions,id',
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'nullable|exists:answers,id',
            'open_answer' => 'nullable|string'
        ]);

        try {
            $result = $this->testSolvingService->submitAnswer(
                $request->session_id,
                $request->question_id,
                $request->answer_id,
                $request->open_answer
            );
            return okResponse($result);
        } catch (\Exception $e) {
            return errorResponse(message: $e->getMessage(), status: 400);
        }
    }

    /**
     * Test yakunlash
     */
    public function finishTest(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:user_test_sessions,id',
        ]);

        try {
            $result = $this->testSolvingService->finishTest($request->session_id);
            return okResponse($result);
        } catch (\Exception $e) {
            return errorResponse(message: $e->getMessage(), status: 400);
        }
    }

    /**
     * Test natijalari
     */
    public function getTestResults(Request $request, $sessionId)
    {
        try {
            $result = $this->testSolvingService->getTestResults($sessionId);
            return okResponse($result);
        } catch (\Exception $e) {
            return errorResponse(message: $e->getMessage(), status: 400);
        }
    }

    /**
     * Foydalanuvchining test tarixi
     */
    public function getUserTestHistory(Request $request)
    {
        try {
            $history = $this->testSolvingService->getUserTestHistory(auth()->id(), $request->per_page ?? 10);
            return okResponse($history);
        } catch (\Exception $e) {
            return errorResponse(message: $e->getMessage(), status: 400);
        }
    }
}
