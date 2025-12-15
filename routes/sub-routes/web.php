<?php

use App\Helpers\Roles;
use App\Http\Controllers\Api\v1\TestSolvingController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\CategoryController::class, 'index']);
        Route::get('/{category}', [App\Http\Controllers\Api\v1\CategoryController::class, 'show'])->whereNumber('category');
    });

    Route::prefix('levels')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\LevelController::class, 'index']);
        Route::get('/{level}', [App\Http\Controllers\Api\v1\LevelController::class, 'show'])->whereNumber('level');
    });

    Route::prefix('questions')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\QuestionController::class, 'index']);
        Route::get('/{question}', [App\Http\Controllers\Api\v1\QuestionController::class, 'show'])->whereNumber('question');
    });

    Route::prefix('answers')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\AnswerController::class, 'index']);
        Route::get('/{answer}', [App\Http\Controllers\Api\v1\AnswerController::class, 'show'])->whereNumber('answer');
    });

    Route::prefix('tests')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\TestController::class, 'index']);
        Route::get('/{test}', [App\Http\Controllers\Api\v1\TestController::class, 'show'])->whereNumber('test');
    });

    Route::prefix('specialities')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\SpecialityController::class, 'index']);
        Route::get('/{speciality}', [App\Http\Controllers\Api\v1\SpecialityController::class, 'show'])->whereNumber('speciality');
    });

    Route::prefix('usertestsessions')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\UserTestSessionController::class, 'index']);
        Route::get('/{usertestsession}', [App\Http\Controllers\Api\v1\UserTestSessionController::class, 'show'])->whereNumber('usertestsession');
    });

    Route::prefix('usertestanswers')->group(function () {
        Route::get('/', [App\Http\Controllers\Api\v1\UserTestAnswerController::class, 'index']);
        Route::get('/{usertestanswer}', [App\Http\Controllers\Api\v1\UserTestAnswerController::class, 'show'])->whereNumber('usertestanswer');
    });


    Route::prefix('test')->group(function () {

        Route::post('/start', [TestSolvingController::class, 'startTest']);

        Route::post('/questions', [TestSolvingController::class, 'getTestQuestions']);

        Route::post('/answer', [TestSolvingController::class, 'submitAnswer']);

        Route::post('/finish', [TestSolvingController::class, 'finishTest']);

        Route::get('/results/{sessionId}', [TestSolvingController::class, 'getTestResults']);

        Route::get('/history', [TestSolvingController::class, 'getUserTestHistory']);

    });
});
