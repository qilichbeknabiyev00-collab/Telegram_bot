<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/', function () {
    return view('welcome');
});
Route::get('setwebhook', function () {
    $response = Telegram::setWebhook(['url' => 'https://scleroblastic-zaiden-sacramentally.ngrok-free.dev/api/telegram/webhook' . env('8272558742:AAEPWwolSTo6c6k7kaVIL1sUqmskhxSf7bI
') . '/webhook']);
    return $response;
});