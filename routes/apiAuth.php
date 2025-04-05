<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'role:admin'])->get('/admin', function () {
    return response()->json(['message' => 'Welcome Admin']);
});

Route::middleware(['auth:api', 'role:user'])->get('/user', function () {
    return response()->json(['message' => 'Welcome User']);
});
