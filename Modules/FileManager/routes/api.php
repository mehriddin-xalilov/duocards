<?php

use App\Helpers\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\FileManager\App\Http\Controllers\FileManagerController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

//Route::prefix('v1/files')->group(function () {
//    Route::post('/upload', [FileManagerController::class, 'upload']);
//});

Route::prefix('v1/admin/files')->middleware(['auth:api'])->group(function () {
    Route::post('/upload', [FileManagerController::class, 'adminUpload']);
    Route::delete('{file}', [FileManagerController::class, 'delete'])->whereNumber('file');
    Route::get('/{file}', [FileManagerController::class, 'show'])->whereNumber('file');
    Route::put('/{file}', [FileManagerController::class, 'update'])->whereNumber('file');
});
Route::prefix('v1/admin/filemanager')->group(function () {
    Route::get('/', [\Modules\FileManager\App\Http\Controllers\FileManagerController::class, 'index']);
    Route::get('/{file}', [\Modules\FileManager\App\Http\Controllers\FileManagerController::class, 'show'])->whereNumber('file');
    Route::delete('/{file}', [\Modules\FileManager\App\Http\Controllers\FileManagerController::class, 'delete'])->whereNumber('file');
});
Route::prefix('v1/admin/filemanager/folder')->group(function () {
    Route::get('/', [\Modules\FileManager\App\Http\Controllers\FolderController::class, 'index']);
    Route::post('/', [\Modules\FileManager\App\Http\Controllers\FolderController::class, 'create']);
    Route::put('/{id}', [\Modules\FileManager\App\Http\Controllers\FolderController::class, 'update']);
    Route::put('/{id}', [\Modules\FileManager\App\Http\Controllers\FolderController::class, 'delete']);
});
Route::prefix('v1')->group(function () {
    Route::post('/upload', [FileManagerController::class, 'adminUpload']);
});
