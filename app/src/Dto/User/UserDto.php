<?php

namespace App\Dto\User;

use DateTimeInterface;

class UserDto
{
	private ?string $name;
	private ?string $login;
	private ?DateTimeInterface $created_at;
	
	/**
	 * @return string|null
	 */
	public function getName(): ?string
	{
		return $this->name;
	}
	
	/**
	 * @param string|null $name
	 *
	 * @return UserDto
	 */
	public function setName(?string $name): UserDto
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getLogin(): ?string
	{
		return $this->login;
	}
	
	/**
	 * @param ?string $login
	 *
	 * @return UserDto
	 */
	public function setLogin(?string $login): UserDto
	{
		$this->login = $login;
		
		return $this;
	}
	
	/**
	 * @return DateTimeInterface|null
	 */
	public function getCreatedAt(): ?DateTimeInterface
	{
		return $this->created_at;
	}
	
	/**
	 * @param DateTimeInterface|null $created_at
	 *
	 * @return UserDto
	 */
	public function setCreatedAt(?DateTimeInterface $created_at): UserDto
	{
		$this->created_at = $created_at;
		
		return $this;
	}
}