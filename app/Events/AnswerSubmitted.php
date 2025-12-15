<?php
namespace App\Events;

use App\Models\Answer;
use App\Models\Question;
use App\Models\UserTestAnswer;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnswerSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UserTestAnswer $userTestAnswer;
    public int $sessionId;
    public int $testId;
    public int $userId;
    public string $questionText;
    public string $answerText;
    public bool $isCorrect;

    /**
     * Create a new event instance.
     */
    public function __construct(UserTestAnswer $userTestAnswer)
    {
        $this->userTestAnswer = $userTestAnswer;
        $this->sessionId = $userTestAnswer->session_id;
        $this->testId = $userTestAnswer->test_id;
        $this->userId = $userTestAnswer->session->user_id;

        // Savol va javob ma'lumotlarini olish
        $question = Question::find($userTestAnswer->question_id);
        $answer = Answer::find($userTestAnswer->answer_id);

        $this->questionText = $question?->question_text ?? 'N/A';
        $this->answerText = $answer?->answer_text ?? 'Javob berilmadi';
        $this->isCorrect = $userTestAnswer->is_correct;
    }

    /**
     * Broadcast qilish kanalini aniqlash
     *
     * Test sessioni uchun private channel
     * Faqat shu sessionning user-i va admin-lar ko'ra oladi
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('test-session.' . $this->sessionId),
        ];
    }

    /**
     * Event nomi (frontend da listen qilish uchun)
     */
    public function broadcastAs(): string
    {
        return 'answer.submitted';
    }

    /**
     * Broadcast qilish ma'lumotlari
     *
     * Faqat zarur ma'lumotlarni jo'natish (sensitive data yo'q)
     */
    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->sessionId,
            'test_id' => $this->testId,
            'user_id' => $this->userId,
            'question_id' => $this->userTestAnswer->question_id,
            'answer_id' => $this->userTestAnswer->answer_id,
            'question_text' => $this->questionText,
            'answer_text' => $this->answerText,
            'is_correct' => $this->isCorrect,
            'answered_at' => $this->userTestAnswer->answered_at->toIso8601String(),
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Qaysi foydalanuvchilarga broadcast qilinmasin (optional)
     *
     * Javob bergan foydalanuvchining o'ziga jo'natmasligi uchun
     */
    public function dontBroadcastToCurrentUser(): bool
    {
        return true;
    }
}
