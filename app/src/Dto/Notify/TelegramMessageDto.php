<?php

namespace App\Dto\Notify;

class TelegramMessageDto
{
    private string $subject;
    private string $chatId;
    private string $message;
    private string $parseMode = 'MarkdownV2';
    private bool $isDisableWebPagePreview = true;
    private bool $isDisableNotification = true;
    
    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * @param mixed $subject
     *
     * @return TelegramMessageDto
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getChatId()
    {
        return $this->chatId;
    }
    
    /**
     * @param mixed $chatId
     *
     * @return TelegramMessageDto
     */
    public function setChatId($chatId)
    {
        $this->chatId = $chatId;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getParseMode(): string
    {
        return $this->parseMode;
    }
    
    /**
     * @param string $parseMode
     *
     * @return TelegramMessageDto
     */
    public function setParseMode(string $parseMode): TelegramMessageDto
    {
        $this->parseMode = $parseMode;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isDisableWebPagePreview(): bool
    {
        return $this->isDisableWebPagePreview;
    }
    
    /**
     * @param bool $isDisableWebPagePreview
     *
     * @return TelegramMessageDto
     */
    public function setIsDisableWebPagePreview(bool $isDisableWebPagePreview): TelegramMessageDto
    {
        $this->isDisableWebPagePreview = $isDisableWebPagePreview;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isDisableNotification(): bool
    {
        return $this->isDisableNotification;
    }
    
    /**
     * @param bool $isDisableNotification
     *
     * @return TelegramMessageDto
     */
    public function setIsDisableNotification(bool $isDisableNotification): TelegramMessageDto
    {
        $this->isDisableNotification = $isDisableNotification;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
    
    /**
     * @param string $message
     *
     * @return TelegramMessageDto
     */
    public function setMessage(string $message): TelegramMessageDto
    {
        $this->message = $message;
        
        return $this;
    }
}
