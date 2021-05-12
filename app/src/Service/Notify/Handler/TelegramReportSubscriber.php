<?php

namespace App\Service\Notify\Handler;

use App\Dto\Notify\TelegramMessageDto;
use App\Service\Notify\Event\SendReportEvent;
use App\Service\Notify\TelegramNotify;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TelegramReportSubscriber implements EventSubscriberInterface
{
    private const CHAT_ID = 265494446;
    
    private TelegramNotify $telegramNotify;
    
    /**
     * TelegramReportSubscriber constructor.
     *
     * @param TelegramNotify $telegramNotify
     */
    public function __construct(TelegramNotify $telegramNotify)
    {
        $this->telegramNotify = $telegramNotify;
    }
    
    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SendReportEvent::NAME => 'onSendReport',
        ];
    }
    
    /**
     * @param SendReportEvent $reportEvent
     */
    final public function onSendReport(SendReportEvent $reportEvent): void
    {
        $reportData = $reportEvent->getReport();
        foreach ($reportData as $text) {
            $reportEvent->setResult(
                [
                    'resultSent' => $this->telegramNotify->setMessage(
                        (new TelegramMessageDto())
                            ->setSubject($text)
                            ->setMessage($text)
                            ->setParseMode('HTML')
                            ->setChatId(self::CHAT_ID)
                    )->send(),
                ]
            );
        }
    }
}
