<?php

namespace App\Http\Services;

use App\Events\AnswerSubmitted;
use App\Events\TestFinished;
use App\Models\Test;
use App\Models\UserTestAnswer;
use App\Models\UserTestSession;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TestSolvingService
{
    /**
     * Test ni boshlash - session yaratish
     */
    public function startTest(int $userId, int $testId)
    {
        $test=Test::findOrFail($testId);

        // Agar foydalanuvchi bu testni allaqachon yechayotgan bo'lsa
        $existingSession = UserTestSession::where('user_id', $userId)
            ->where('test_id', $testId)
            ->where('status', 'in_progress')
            ->first();

        if ($existingSession) {
            return [
                'success' => true,
                'session' => $existingSession,
                'message' => 'Test allaqachon boshlangan',
                'is_existing' => true
            ];
        }

        // Yangi session yaratish
        $session = UserTestSession::create([
            'user_id' => $userId,
            'test_id' => $testId,
            'started_at' => Carbon::now(),
            'status' => 'in_progress'
        ]);

        return [
            'success' => true,
            'session' => $session,
            'message' => 'Test boshlandi',
            'is_existing' => false
        ];
    }

    /**
     * Test savollarini olish (randomized bo'lishi mumkin)
     */
    public function getTestQuestions(int $sessionId)
    {
        $session = UserTestSession::with('test')->findOrFail($sessionId);
        $test = $session->test;
        if ($session->status !== 'in_progress') {
            throw new \Exception('Test tugangan yoki yaroqsiz sessiya');
        }

        // Test savollari qanday olish kerakligini aniqlash
        $questions = $this->fetchQuestions($test);

        // Savollarni aralashtirish
        if ($test->randomize_questions) {
            shuffle($questions);
        }

        // Har bir savolning variantlarini olish
        $questionsWithAnswers = $this->attachAnswersToQuestions($questions, $test);

        return [
            'success' => true,
            'test_info' => [
                'id' => $test->id,
                'name' => $test->name,
                'time_limit' => $test->time_limit,
                'test_type' => $test->test_type
            ],
            'session_id' => $session->id,
            'total_questions' => count($questionsWithAnswers),
            'questions' => $questionsWithAnswers
        ];
    }

    /**
     * Test turi bo'yicha savollarni olish
     */
    private function fetchQuestions(Test $test): array
    {
        if ($test->test_type == 1) {
            // Sertifikat testi - category bo'yicha, test_type=1 bilan
            return DB::table('test_questions')
                ->join('questions', 'test_questions.question_id', '=', 'questions.id')
                ->where('test_questions.test_id', $test->id)
                ->where('questions.test_type', 1)  // ← YANGI
                ->select('questions.id', 'questions.question_text', 'questions.photo', 'questions.type')
                ->distinct()
                ->get()
                ->toArray();
        } else {
            // Interview testi - level va speciality bo'yicha, test_type=2 bilan
            return DB::table('questions')
                ->where('level_id', $test->level_id)
                ->where('test_type', 2)  // ← YANGI
                ->select('id', 'question_text', 'photo', 'type')
                ->inRandomOrder()
                ->limit($test->questions_count ?? 10)
                ->get()
                ->toArray();
        }
    }

    /**
     * Savolga javob variantlarini qo'shish
     */
    private function attachAnswersToQuestions(array $questions, Test $test): array
    {
        $questionsWithAnswers = [];

        foreach ($questions as $question) {
            $answers = DB::table('answers')
                ->where('question_id', $question->id)
                ->select('id', 'answer_text', 'type')
                ->get()
                ->toArray();

            if ($test->randomize_answers) {
                shuffle($answers);
            }

            $questionsWithAnswers[] = [
                'question' => $question,
                'answers' => $answers
            ];
        }

        return $questionsWithAnswers;
    }

    /**
     * Bitta savol uchun javob saqlash
     */
    public function submitAnswer(int $sessionId, int $questionId, ?int $answerId, ?string $openAnswer)
    {
        $session = UserTestSession::with('test')->findOrFail($sessionId);
        $test = $session->test;

        // Session validation
        if ($session->status !== 'in_progress') {
            throw new \Exception('Test tugangan, javob berish mumkin emas');
        }

        // Javob to'g'ri yoki noto'g'rimi?
        $isCorrect = false;
        if ($answerId) {
            $isCorrect = $this->validateAnswer($questionId, $answerId);
        }

        // Javobni saqlash
        $userTestAnswer = UserTestAnswer::updateOrCreate(
            [
                'session_id' => $session->id,
                'question_id' => $questionId
            ],
            [
                'test_id' => $test->id,
                'answer_id' => $answerId,
                'is_correct' => $isCorrect,
                'answered_at' => Carbon::now()
            ]
        );

        // Event broadcast qilish
        broadcast(new AnswerSubmitted($userTestAnswer))->toOthers();

        return [
            'success' => true,
            'is_correct' => $isCorrect,
            'message' => $isCorrect ? 'To\'g\'ri!' : 'Noto\'g\'ri!'
        ];
    }

    /**
     * Javob to'g'ri ekanligini tekshirish
     */
    private function validateAnswer(int $questionId, int $answerId): bool
    {
        $answer = DB::table('answers')
            ->where('id', $answerId)
            ->where('question_id', $questionId)
            ->first();

        return $answer ? (bool)$answer->is_correct : false;
    }

    /**
     * Testni yakuniy validatsiya va natijalari bilan yakunlash
     */
    public function finishTest(int $sessionId)
    {
        $session = UserTestSession::with('test')->findOrFail($sessionId);

        // Agar test allaqachon tugagan bo'lsa
        if ($session->status === 'completed') {
            return [
                'success' => true,
                'message' => 'Test allaqachon tugagan',
                'session' => $session
            ];
        }

        // Statistikani hisoblash
        $statistics = $this->calculateStatistics($session->id);

        // Session ni tugallash
        $session->update([
            'finished_at' => Carbon::now(),
            'status' => 'completed',
            'correct_answers' => $statistics['correct_answers'],
            'wrong_answers' => $statistics['wrong_answers'],
            'score' => $statistics['percentage']
        ]);

        // Event broadcast qilish
        broadcast(new TestFinished($session))->toOthers();

        return [
            'success' => true,
            'result' => [
                'session_id' => $session->id,
                'total_questions' => $statistics['total_questions'],
                'correct_answers' => $statistics['correct_answers'],
                'wrong_answers' => $statistics['wrong_answers'],
                'percentage' => $statistics['percentage'],
                'passed' => $statistics['passed'],
                'test_type' => $session->test->test_type,
                'time_spent' => $session->started_at->diffInMinutes($session->finished_at)
            ],
            'message' => 'Test tugadi'
        ];
    }

    /**
     * Statistikani hisoblash
     */
    private function calculateStatistics(int $sessionId): array
    {
        $answers = UserTestAnswer::where('session_id', $sessionId)->get();
        $totalQuestions = $answers->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $wrongAnswers = $totalQuestions - $correctAnswers;
        $percentage = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

        return [
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'percentage' => round($percentage, 2),
            'passed' => $percentage >= 70
        ];
    }

    /**
     * Test natijalari va statistika
     */
    public function getTestResults(int $sessionId)
    {
        $session = UserTestSession::with('test', 'user')->findOrFail($sessionId);
        $answers = UserTestAnswer::with(['question', 'answer'])
            ->where('session_id', $sessionId)
            ->get();

        // Har bir savol uchun batafsil javob ma'lumotlari
        $detailedAnswers = $this->buildDetailedAnswers($answers);

        return [
            'success' => true,
            'session' => [
                'id' => $session->id,
                'user' => [
                    'id' => $session->user->id,
                    'name' => $session->user->name,
                    'email' => $session->user->email
                ],
                'test_name' => $session->test->name,
                'test_type' => $session->test->test_type,
                'started_at' => $session->started_at,
                'finished_at' => $session->finished_at,
                'status' => $session->status,
                'correct_answers' => $session->correct_answers,
                'wrong_answers' => $session->wrong_answers,
                'score' => $session->score
            ],
            'answers' => $detailedAnswers
        ];
    }

    /**
     * Batafsil javoblarni qurilish
     */
    private function buildDetailedAnswers($answers): array
    {
        return $answers->map(function ($answer) {
            return [
                'question_id' => $answer->question_id,
                'question_text' => $answer->question->question_text,
                'user_answer_id' => $answer->answer_id,
                'user_answer_text' => $answer->answer->answer_text ?? 'Javob berilmadi',
                'is_correct' => $answer->is_correct,
                'correct_answer' => DB::table('answers')
                    ->where('question_id', $answer->question_id)
                    ->where('is_correct', true)
                    ->value('answer_text')
            ];
        })->toArray();
    }

    /**
     * Foydalanuvchining barcha test natijalari
     */
    public function getUserTestHistory(int $userId, int $perPage = 10)
    {
        return UserTestSession::with('test')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->orderByDesc('finished_at')
            ->paginate($perPage);
    }

    /**
     * Test sessioni ma'lumotlarini olish
     */
    public function getSession(int $sessionId)
    {
        return UserTestSession::with('test')->findOrFail($sessionId);
    }

    /**
     * Session barcha javoblarini olish
     */
    public function getSessionAnswers(int $sessionId)
    {
        return UserTestAnswer::with(['question', 'answer'])
            ->where('session_id', $sessionId)
            ->get();
    }
}
