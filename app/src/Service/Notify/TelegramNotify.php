<?php

namespace App\Service\Notify;

use App\Dto\Notify\TelegramMessageDto;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\SentMessage;

/**
 * Class TelegramNotify
 */
class TelegramNotify extends AbstractNotify
{
    private ?TelegramMessageDto $message;
    private ChatterInterface $chatter;
    
    /**
     * TelegramNotify constructor.
     *
     * @param ChatterInterface $chatter
     */
    public function __construct(ChatterInterface $chatter)
    {
        $this->chatter = $chatter;
    }
    
    public function send(): ?SentMessage
    {
        $chatMessage = new ChatMessage($this->message->getSubject());
        
        // Create Telegram options
        $telegramOptions = (new TelegramOptions())
            ->chatId($this->message->getChatId())
            ->parseMode($this->message->getParseMode())
            ->disableWebPagePreview($this->message->isDisableWebPagePreview())
            ->disableNotification($this->message->isDisableNotification());
        
        // Add the custom options to the chat message and send the message
        $chatMessage->options($telegramOptions);
        
        return $this->chatter->send($chatMessage);
    }
    
    public function setMessage(TelegramMessageDto $telegramMessageDto)
    {
        $this->message = $telegramMessageDto;
        
        return $this;
    }
}
