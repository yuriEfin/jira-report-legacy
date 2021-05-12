<?php

namespace App\Service\Rabbit\Interfaces;

/**
 * Interface MessageServiceInterface
 */
interface MessageServiceInterface
{
	public function createMessage(string $data): bool;
}