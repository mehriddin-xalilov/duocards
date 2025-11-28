<?php

namespace Modules\Company\App\Services\Vacancy\Interface;

/**
 * Vacancy Statistics Service Interface
 * 
 * Vakansiya statistika servisi uchun interface
 * 
 * TODO: Quyidagi metodlarni implement qilish kerak
 */
interface iVacancyStatisticsService
{
    /**
     * Vakansiya statistikasini olish
     * 
     * @param int $vacancyId
     * @return array
     */
    public function getStatistics(int $vacancyId): array;

    /**
     * Vakansiya ko'rishini saqlash
     * 
     * @param int $vacancyId
     * @param int|null $userId
     * @param string|null $ipAddress
     * @return void
     */
    public function trackView(int $vacancyId, ?int $userId = null, ?string $ipAddress = null): void;

    /**
     * Talaba va vakansiya o'rtasidagi matching score'ni hisoblash
     * 
     * @param int $studentId
     * @param int $vacancyId
     * @return float (0-100)
     */
    public function calculateMatchScore(int $studentId, int $vacancyId): float;
}

