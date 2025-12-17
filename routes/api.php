<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SectionController;

// php artisan install:api コマンドでApiのルーティングの作成

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// class_idに紐づくセクション取得用のApi ※認証済みのページから呼び出しているので、middleware('auth')は不要
Route::get('sections', [SectionController::class, 'index']);
