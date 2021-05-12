<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
class Department
{
    public const UNKNOWN = 6;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $created_at;
	
	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}
	
	/**
	 * @param int $id
	 *
	 * @return Department
	 */
	public function setId(int $id): Department
	{
		$this->id = $id;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}
	
	/**
	 * @param string $name
	 *
	 * @return Department
	 */
	public function setName(string $name): Department
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * @return DateTimeInterface
	 */
	public function getCreatedAt(): DateTimeInterface
	{
		return $this->created_at;
	}
	
	/**
	 * @param DateTimeInterface $created_at
	 *
	 * @return Department
	 */
	public function setCreatedAt(DateTimeInterface $created_at): Department
	{
		$this->created_at = $created_at;
		
		return $this;
	}
}
