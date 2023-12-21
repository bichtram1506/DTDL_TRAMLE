<?php
namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('Hi', function ($bot) {
            $bot->reply('Xin chào! Bạn có cần chúng tôi hỗ trợ gì không, đừng ngại hãy chat với chúng tôi ngay đi');

            // Bắt đầu cuộc trò chuyện về tour du lịch
            $bot->startConversation(new OnboardingConversation());
        });

        // Lắng nghe liên tục để xử lý các câu hỏi tiếp theo
        $botman->listen();
    }
}

// Class OnboardingConversation được đặt trong một tệp riêng biệt
namespace App\Http\Controllers\Page;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class OnboardingConversation extends Conversation
{
    protected $firstname;

    protected $email;

    public function askFirstname()
    {
        $this->ask('Hello! Tên của bạn là gì??', function(Answer $answer) {
            // Save result
            $this->firstname = $answer->getText();

            $this->say('Rất vui được gặp bạn '.$this->firstname);
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('Một điều nữa - email của bạn là gì?', function(Answer $answer) {
            // Save result
            $this->email = $answer->getText();

            $this->say('Tốt lắm - đó là tất cả những gì chúng tôi cần. '.$this->firstname);
        });
    }

    public function run()
    {
        // This will be called immediately
        $this->askFirstname();
    }
}
