<?php

namespace App\Service\Rabbit;

use App\Service\Rabbit\Interfaces\MessageServiceInterface;

/**
 * Class MessageService
 */
class MessageService implements MessageServiceInterface
{
	private MessagingProducer $messagingProducer;
	
	/**
	 * MessageService constructor.
	 *
	 * @param MessagingProducer $messagingProducer
	 */
	public function __construct(MessagingProducer $messagingProducer)
	{
		$this->messagingProducer = $messagingProducer;
	}
	
	/**
	 * @param string $data - JSON
	 *
	 * @return bool
	 */
	public function createMessage(string $data): bool
	{
		$this->messagingProducer->publish($data);
		
		return true;
	}
}
