<?php

use App\Http\Controllers\FormController;
use Illuminate\Http\Request;

Route::apiResource('forms', FormController::class)->only(['index', 'store']);