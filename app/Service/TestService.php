<?php

namespace App\Services;

use Telegram\Bot\Laravel\Facades\Telegram;

class TestService
{
    public function startTest($user, $rating)
    {
        $chatId = $user->telegram_id;

        if ($rating <= 2) {
            $this->sendStressTest($chatId);
        } elseif ($rating == 3) {
            $this->sendNeutralTest($chatId);
        } else {
            $this->sendMotivationTest($chatId);
        }
    }

    private function sendStressTest($chatId)
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "🧘‍♂️ Stress testni boshlaymiz:\n1️⃣ Oxirgi kunlarda o‘zingizni charchagan his qilyapsizmi?"
        ]);
    }

    private function sendNeutralTest($chatId)
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "😐 Neytral test:\n1️⃣ Bugun sizni eng ko‘p o‘ylantirgan narsa nima?"
        ]);
    }

    private function sendMotivationTest($chatId)
    {
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => "🔥 Motivatsion test:\n1️⃣ Hozir sizni nima ilhomlantiryapti?"
        ]);
    }
}
