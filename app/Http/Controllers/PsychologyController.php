<?php

namespace App\Http\Controllers;

use App\Models\TelegramUser;
use App\Models\MoodLog;
use App\Models\SessionLog;
use App\Services\Telegram\TelegramService;

class PsychologyController extends Controller
{
    protected $bot;

   

    public function handleMessage(TelegramUser $user, $text)
    {
        if ($text === '/mood') {
            return $this->askMood($user);
        }

        return $this->bot->sendMessage($user->telegram_id, "Iltimos /mood buyrug`ini bosing.");
    }

    public function handleCallback($cb)
    {
        $chatId = $cb['message']['chat']['id'];
        $data = $cb['data'];

        $user = TelegramUser::where('telegram_id', $chatId)->first();

        if (str_starts_with($data, 'mood_')) {
            $rating = intval(substr($data, 5));
            MoodLog::create([
                'telegram_user_id' => $user->id,
                'rating' => $rating
            ]);

            $this->bot->sendMessage($chatId, "Kayfiyatingiz saqlandi ✅\nTestni boshlash uchun /psychology ni bosing.");
        }
    }

    public function askMood(TelegramUser $user)
    {
        $reply = [
            'inline_keyboard' => [
                [
                    ['text' => '1 😞', 'callback_data' => 'mood_1'],
                    ['text' => '2 😕', 'callback_data' => 'mood_2'],
                    ['text' => '3 😐', 'callback_data' => 'mood_3'],
                    ['text' => '4 🙂', 'callback_data' => 'mood_4'],
                    ['text' => '5 😄', 'callback_data' => 'mood_5'],
                ]
            ]
        ];

        return $this->bot->sendMessage($user->telegram_id, "Bugungi kayfiyatingizni baholang (1–5):", $reply);
    }
}
