<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $token;
    protected $apiUrl;

    public function __construct()
    {
        // .env fayldagi tokenni oladi
        $this->token = config('services.telegram.bot_token');
        $this->apiUrl = "https://api.telegram.org/bot{$this->token}/";
    }

    /**
     * Xabar yuborish
     *
     * @param int $chatId
     * @param string $text
     * @param array|null $replyMarkup
     * @return \Illuminate\Http\Client\Response
     */
    public function sendMessage($chatId, $text, $replyMarkup = null)
    {
        $payload = [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML'
        ];

        if ($replyMarkup) {
            $payload['reply_markup'] = json_encode($replyMarkup);
        }

        return Http::post($this->apiUrl . 'sendMessage', $payload);
    }

    /**
     * Inline tugmalar yuborish (optional)
     *
     * @param int $chatId
     * @param string $text
     * @param array $buttons
     */
    public function sendInlineButtons($chatId, $text, $buttons)
    {
        $replyMarkup = [
            'inline_keyboard' => $buttons
        ];

        return $this->sendMessage($chatId, $text, $replyMarkup);
    }

    /**
     * Telegram API dan boshqa so‘rovlar yuborish (generic)
     *
     * @param string $method
     * @param array $data
     */
    public function request($method, $data = [])
    {
        return Http::post($this->apiUrl . $method, $data);
    }
}
