<?php

use App\Http\Controllers\GoogleAuthApiController;
use App\Http\Controllers\CopyrightTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\IndustryTypeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PriorityTypeController;
use App\Http\Controllers\StatusTypeController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Storage;

Route::apiResource('courses', CourseController::class);

Route::apiResource('lessons', LessonController::class);
Route::get('/lesson/random', [LessonController::class, 'random']);

Route::apiResource('copyrighttypes', CopyrightTypeController::class);

Route::apiResource('industrytypes', IndustryTypeController::class);

Route::apiResource('prioritytypes', PriorityTypeController::class);

Route::apiResource('statustypes', StatusTypeController::class);

Route::apiResource('accounts', AccountController::class);

// Route cập nhật vai trò cho tài khoản
Route::put('accounts/{id}/role', [AccountController::class, 'updateRole']);

Route::get('/auth/google', [GoogleAuthApiController::class, 'redirectToGoogle']);

Route::get('/auth/google/callback', [GoogleAuthApiController::class, 'handleGoogleCallback']);



Route::get('/test-s3', function (Request $request) {
    try {
        // Kiểm tra kết nối bằng cách liệt kê file trong bucket
        $files = Storage::disk('s3')->files();
        return response()->json([
            'message' => 'Kết nối S3 thành công',
            'files' => $files
        ]);
    } catch (\Aws\S3\Exception\S3Exception $e) {
        return response()->json([
            'message' => 'Lỗi kết nối S3',
            'error' => $e->getMessage()
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Lỗi khác',
            'error' => $e->getMessage()
        ], 500);
    }
});
