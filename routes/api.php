<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PsychologyController;
use Illuminate\Cache\Console\PruneStaleTagsCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Http\Controllers\TelegramBotController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('setwebhook', function (Request $request) {
    $respose = Telegram::setWebhook(['url' => env('https://scleroblastic-zaiden-sacramentally.ngrok-free.dev/api/telegram/webhook')]);
});


use App\Http\Controllers\TelegramController;

Route::post('/telegram/webhook', [TelegramBotController::class, 'hendle']);
Route::post('/auth/start', [AuthController::class, 'start']);
Route::post('/auth/verify', [AuthController::class, 'verify']);

// Psixolog test va maslahat jarayonlari
Route::post('/psychology/check-mood', [PsychologyController::class, 'handleMessage']);
Route::post('/psychology/run-test', [PsychologyController::class, 'handleCallback']);
Route::post('/psychology/advice', [PsychologyController::class, 'askMood']);
