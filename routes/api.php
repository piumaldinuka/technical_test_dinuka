<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Middleware\HandleCors;

Route::apiResource('user-details', UserProfileController::class);

