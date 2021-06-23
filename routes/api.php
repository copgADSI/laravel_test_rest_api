<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/reset', [ResetController::class,'reset']);
Route::get('/balance', [BalanceController::class,'show']);
Route::post('/event',  [EventController::class,'show']);
/* 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */
