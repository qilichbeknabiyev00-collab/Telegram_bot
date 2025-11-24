<?php

namespace App\Telegram\Commands;
use Illuminate\Console\Command;
use Telegram\Bot\Keyboard\Keyboard;

class StartCommand extends Command
{
    protected $name = 'start';
    protected $description = 'Handle /start command from Telegram bot';

    public function handle()
    {
        $kaybord = Keyboard::make()
            ->row(
            [ Keyboard::button(['text' => 'Yaxshi odat qo`shish']),
                Keyboard::button(['text' => 'Yomon odat qo`shish'])]
            )
            ->row(
                Keyboard::button(['text' => 'Ro`yxatni ko`rish'])
            );
            
            $this->replyWithMessage([
                'text' => "Salom! 😊\nMen sizga yaxshi/yomon odatlaringizni boshqarishda yordam beraman.\n\n"
                ."👉 Yaxshi odat qo`shish: /add_good\n"
                ."👉 Yomon odat qo`shish: /add_bad\n"
                ."👉 Ro`yxatni ko`rish: /list",
                'reply_markup' => $kaybord
            ]);
    }

}

