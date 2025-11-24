<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use App\Services\Telegram\TelegramService;

class AuthController extends Controller
{
    public function handleAuth(TelegramUser $user, $text)
    {
        $bot = new TelegramService();

        switch ($user->auth_step) {
            case 'name':
                $user->full_name = $text;
                $user->auth_step = 'age';
                $user->save();
                return $bot->sendMessage($user->telegram_id, "Yoshingizni kiriting:");
            case 'age':
                if (!is_numeric($text)) {
                    return $bot->sendMessage($user->telegram_id, "Iltimos, raqam kiriting:");
                }
                $user->age = intval($text);
                $user->auth_step = 'gender';
                $user->save();
                return $bot->sendMessage($user->telegram_id, "Jinsingizni tanlang: Male yoki Female");
            case 'gender':
               $user->gender = $text;
                $user->gender = strtolower($text);
                $user->auth_step = 'done';
                $user->status = 'auth_completed';
                $user->save();
                return $bot->sendMessage($user->telegram_id, "Rahmat! Siz ro‘yxatdan o‘tdingiz ✅\nEndi /psychology orqali davom eting.");
        }
    }
}
