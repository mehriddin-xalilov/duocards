<?php

use App\Models\User;
use App\Models\UserTestSession;
use Illuminate\Support\Facades\Broadcast;


/**
 * Test sessioni uchun private channel
 *
 * Faqat shu sessionning user-i va admin-lar ko'ra oladi
 */
Broadcast::channel('test-session.{sessionId}', function (User $user, $sessionId) {
    $session = UserTestSession::find($sessionId);

    if (!$session) {
        return false;
    }

    // Foydalanuvchi o'zining sessionini ko'ra oladi
    if ($session->user_id === $user->id) {
        return ['id' => $user->id, 'name' => $user->name];
    }

    // Admin barcha sessionlarni ko'ra oladi
    if ($user->hasRole('admin')) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => 'admin'];
    }

    return false;
});

/**
 * Admin test monitoring uchun private channel
 *
 * Test natijalari haqida monitoring
 */
Broadcast::channel('admin.test-monitoring.{testId}', function (User $user, $testId) {
    // Faqat admin-lar bu kanalga kirishi mumkin
    if ($user->hasRole('admin')) {
        return ['id' => $user->id, 'name' => $user->name, 'role' => 'admin'];
    }

    return false;
});

/**
 * User shaxsiy notification kanalı
 *
 * Foydalanuvchi o'ziga jo'natilgan xabarlar
 */
Broadcast::channel('user-notifications.{userId}', function (User $user, $userId) {
    return (int)$user->id === (int)$userId;
});

/**
 * Test statistikasi uchun public channel (optional)
 *
 * Barcha foydalanuvchilar ko'ra oladi (aggregated data)
 */
Broadcast::channel('test.statistics', function () {
    return true;
});
