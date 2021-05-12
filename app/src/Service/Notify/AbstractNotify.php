<?php

namespace App\Service\Notify;

use Symfony\Component\Notifier\Message\SentMessage;

/**
 * Class AbstractNotify
 */
abstract class AbstractNotify
{
    abstract public function send(): ?SentMessage;
}