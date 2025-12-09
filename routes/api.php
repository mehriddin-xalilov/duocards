<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/', function (Request $request) {
        return okResponse(['version' => '1.0.0']);
    });
    Route::group(['prefix' => 'auth',], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('social-login', [AuthController::class, "socialLogin"]);
    });
    Route::group(['prefix' => 'auth/admin',], function () {
        Route::post('login', [AuthController::class, 'adminLogin']);
    });
});

Route::prefix('v1')->group(function () {
    Route::middleware('auth:api')->group(function () {

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/get-me', [App\Http\Controllers\Api\v1\AuthController::class, 'getMe']);
            Route::put('/update-me', [App\Http\Controllers\Api\v1\AuthController::class, 'updateMe']);
            Route::post('/logout', [App\Http\Controllers\Api\v1\AuthController::class, 'logout']);

        });
    });
});
//-------------- Admin start ------------------//
require __DIR__.'/sub-routes/admin.php';
//-------------- Admin end ------------------//


//-------------- Clint start ------------------//

require __DIR__.'/sub-routes/web.php';

//-------------- Clint end ------------------//




Route::prefix('categories')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\CategoryController::class, 'adminIndex']);
    Route::post('/', [App\Http\Controllers\Api\v1\CategoryController::class, 'store']);
    Route::put('/{category}', [App\Http\Controllers\Api\v1\CategoryController::class, 'update'])->whereNumber('category');
    Route::get('/{category}', [App\Http\Controllers\Api\v1\CategoryController::class, 'show'])->whereNumber('category');
    Route::delete('/{category}', [App\Http\Controllers\Api\v1\CategoryController::class, 'destroy'])->whereNumber('category');
});
Route::prefix('categories')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\CategoryController::class, 'index']);
    Route::get('/{category}', [App\Http\Controllers\Api\v1\CategoryController::class, 'show'])->whereNumber('category');
});
Route::prefix('levels')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\LevelController::class, 'adminIndex']);
    Route::post('/', [App\Http\Controllers\Api\v1\LevelController::class, 'store']);
    Route::put('/{level}', [App\Http\Controllers\Api\v1\LevelController::class, 'update'])->whereNumber('level');
    Route::get('/{level}', [App\Http\Controllers\Api\v1\LevelController::class, 'show'])->whereNumber('level');
    Route::delete('/{level}', [App\Http\Controllers\Api\v1\LevelController::class, 'destroy'])->whereNumber('level');
});
Route::prefix('levels')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\LevelController::class, 'index']);
    Route::get('/{level}', [App\Http\Controllers\Api\v1\LevelController::class, 'show'])->whereNumber('level');
});
Route::prefix('questions')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\QuestionController::class, 'adminIndex']);
    Route::post('/', [App\Http\Controllers\Api\v1\QuestionController::class, 'store']);
    Route::put('/{question}', [App\Http\Controllers\Api\v1\QuestionController::class, 'update'])->whereNumber('question');
    Route::get('/{question}', [App\Http\Controllers\Api\v1\QuestionController::class, 'show'])->whereNumber('question');
    Route::delete('/{question}', [App\Http\Controllers\Api\v1\QuestionController::class, 'destroy'])->whereNumber('question');
});
Route::prefix('questions')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\QuestionController::class, 'index']);
    Route::get('/{question}', [App\Http\Controllers\Api\v1\QuestionController::class, 'show'])->whereNumber('question');
});

Route::prefix('answers')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\AnswerController::class, 'adminIndex']);
    Route::post('/', [App\Http\Controllers\Api\v1\AnswerController::class, 'store']);
    Route::put('/{answer}', [App\Http\Controllers\Api\v1\AnswerController::class, 'update'])->whereNumber('answer');
    Route::get('/{answer}', [App\Http\Controllers\Api\v1\AnswerController::class, 'show'])->whereNumber('answer');
    Route::delete('/{answer}', [App\Http\Controllers\Api\v1\AnswerController::class, 'destroy'])->whereNumber('answer');
});
Route::prefix('answers')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\AnswerController::class, 'index']);
    Route::get('/{answer}', [App\Http\Controllers\Api\v1\AnswerController::class, 'show'])->whereNumber('answer');
});
Route::prefix('useranswers')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\UserAnswerController::class, 'adminIndex']);
    Route::post('/', [App\Http\Controllers\Api\v1\UserAnswerController::class, 'store']);
    Route::put('/{useranswer}', [App\Http\Controllers\Api\v1\UserAnswerController::class, 'update'])->whereNumber('useranswer');
    Route::get('/{useranswer}', [App\Http\Controllers\Api\v1\UserAnswerController::class, 'show'])->whereNumber('useranswer');
    Route::delete('/{useranswer}', [App\Http\Controllers\Api\v1\UserAnswerController::class, 'destroy'])->whereNumber('useranswer');
});
Route::prefix('useranswers')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\UserAnswerController::class, 'index']);
    Route::get('/{useranswer}', [App\Http\Controllers\Api\v1\UserAnswerController::class, 'show'])->whereNumber('useranswer');
});
Route::prefix('userprogresses')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\UserProgressController::class, 'adminIndex']);
    Route::post('/', [App\Http\Controllers\Api\v1\UserProgressController::class, 'store']);
    Route::put('/{userprogress}', [App\Http\Controllers\Api\v1\UserProgressController::class, 'update'])->whereNumber('userprogress');
    Route::get('/{userprogress}', [App\Http\Controllers\Api\v1\UserProgressController::class, 'show'])->whereNumber('userprogress');
    Route::delete('/{userprogress}', [App\Http\Controllers\Api\v1\UserProgressController::class, 'destroy'])->whereNumber('userprogress');
});
Route::prefix('userprogresses')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\v1\UserProgressController::class, 'index']);
    Route::get('/{userprogress}', [App\Http\Controllers\Api\v1\UserProgressController::class, 'show'])->whereNumber('userprogress');
});