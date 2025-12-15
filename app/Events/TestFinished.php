<?php

namespace App\Events;

use App\Models\UserTestSession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestFinished implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public UserTestSession $session;
    public int $sessionId;
    public int $testId;
    public int $userId;
    public string $testName;
    public int $correctAnswers;
    public int $wrongAnswers;
    public int $totalQuestions;
    public float $score;
    public bool $passed;
    public int $timeTaken; // Minutlarda

    /**
     * Create a new event instance.
     */
    public function __construct(UserTestSession $session)
    {
        $this->session = $session;
        $this->sessionId = $session->id;
        $this->testId = $session->test_id;
        $this->userId = $session->user_id;
        $this->testName = $session->test->name;
        $this->correctAnswers = $session->correct_answers ?? 0;
        $this->wrongAnswers = $session->wrong_answers ?? 0;
        $this->totalQuestions = $this->correctAnswers + $this->wrongAnswers;
        $this->score = $session->score ?? 0;
        $this->passed = $this->score >= 70;
        $this->timeTaken = $session->started_at->diffInMinutes($session->finished_at);
    }

    /**
     * Broadcast qilish kanalini aniqlash
     *
     * Private channel - faqat test o'qituvchisi va admin-lar
     * Yoki public channel - barcha admin-lar uchun monitoring
     */
    public function broadcastOn(): array
    {
        return [
            // Test sessioni uchun private channel
            new PrivateChannel('test-session.' . $this->sessionId),

            // Admin monitoring uchun (optional)
            new PrivateChannel('admin.test-monitoring.' . $this->testId),
        ];
    }

    /**
     * Event nomi (frontend da listen qilish uchun)
     */
    public function broadcastAs(): string
    {
        return 'test.finished';
    }

    /**
     * Broadcast qilish ma'lumotlari
     */
    public function broadcastWith(): array
    {
        return [
            'session_id' => $this->sessionId,
            'test_id' => $this->testId,
            'user_id' => $this->userId,
            'test_name' => $this->testName,
            'correct_answers' => $this->correctAnswers,
            'wrong_answers' => $this->wrongAnswers,
            'total_questions' => $this->totalQuestions,
            'score' => $this->score,
            'percentage' => round(($this->correctAnswers / max($this->totalQuestions, 1)) * 100, 2),
            'passed' => $this->passed,
            'passed_text' => $this->passed ? 'O\'tdi' : 'O\'tmadi',
            'time_taken_minutes' => $this->timeTaken,
            'time_taken_formatted' => $this->formatTime($this->timeTaken),
            'finished_at' => $this->session->finished_at->toIso8601String(),
            'timestamp' => now()->toIso8601String(),
        ];
    }

    /**
     * Vaqtni formatlash (minutdan soat va minutga)
     */
    private function formatTime(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;

        if ($hours > 0) {
            return "{$hours}h {$mins}m";
        }

        return "{$mins}m";
    }

    /**
     * Qaysi foydalanuvchilarga broadcast qilinmasin
     *
     * Test tugatgan foydalanuvchining o'ziga ham broadcast qilinadi
     */
    public function dontBroadcastToCurrentUser(): bool
    {
        return false;
    }
}
