<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TelegramUser;
use App\Models\MoodLog;
use App\Services\TestService;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();

        // ---------- 1. ODDIY MESSAGE KELSA ----------
        if ($update->getMessage()) {

            $chatId = $update->getMessage()->getChat()->getId();
            $messageText = $update->getMessage()->getText();

            if ($messageText == '/start') {

                // Foydalanuvchini ro‘yxatdan o‘tkazamiz
                TelegramUser::firstOrCreate(['telegram_id' => $chatId]);

                // Inline tugmalar
                $replyMarkup = [
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

                // Start xabari
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "Assalomu alaykum! 😊\nIltimos, hozirgi kayfiyatingizni baholang:",
                    'reply_markup' => json_encode($replyMarkup)
                ]);
            }

            return;
        }

        // ---------- 2. CALLBACK KELSA ----------
        if ($update->getCallbackQuery()) {

            $callback = $update->getCallbackQuery();
            $data = $callback->getData();
            $chatId = $callback->getMessage()->getChat()->getId();

            $user = TelegramUser::where('telegram_id', $chatId)->first();

            // === MOOD QABUL QILINDI ===
            if (str_starts_with($data, 'mood_')) {

                $rating = intval(substr($data, 5));

                MoodLog::create([
                    'telegram_user_id' => $user->id,
                    'rating' => $rating
                ]);

                // Kayfiyat haqida javoblar
                $messages = [
                    1 => "😞 Sizni tushkun holatda ko‘ryapman... Gaplashishni xohlaysizmi?",
                    2 => "😕 Bugun uncha yaxshi kun emas shekilli. Men sizga yordam bera olaman.",
                    3 => "😐 O‘rtacha kayfiyat. Hozir psixologik test boshlaymiz.",
                    4 => "🙂 Yaxshi kayfiyat! Keling, qisqa test qilib olamiz.",
                    5 => "😄 Ajoyib kayfiyat! Testni soddaroq boshlaymiz."
                ];

                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => $messages[$rating]
                ]);

                // Testni boshlash
                (new TestService())->startTest($user, $rating);

                return;
            }
        }
    }
}
