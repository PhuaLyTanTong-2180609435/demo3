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
use App\Http\Controllers\GoogleAuthController;

Route::apiResource('courses', CourseController::class);

Route::apiResource('lessons', LessonController::class);

Route::apiResource('copyrighttypes', CopyrightTypeController::class);

Route::apiResource('industrytypes', IndustryTypeController::class);

Route::apiResource('prioritytypes', PriorityTypeController::class);

Route::apiResource('statustypes', StatusTypeController::class);

Route::get('/auth/google', [GoogleAuthApiController::class, 'redirectToGoogle']);

Route::get('/auth/google/callback', [GoogleAuthApiController::class, 'handleGoogleCallback']);
