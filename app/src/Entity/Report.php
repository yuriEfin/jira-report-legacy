<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private ?int $id;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private ?string $name;
	
	/**
	 * @ORM\Column(type="text", nullable=false)
	 */
	private string $filter;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	private DateTimeInterface $created_at;
	
	/**
	 * @return int|null
	 */
	public function getId(): ?int
	{
		return $this->id;
	}
	
	/**
	 * @param int|null $id
	 *
	 * @return Report
	 */
	public function setId(?int $id): Report
	{
		$this->id = $id;
		
		return $this;
	}
	
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
	 * @return Report
	 */
	public function setName(?string $name): Report
	{
		$this->name = $name;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getFilter(): ?string
	{
		return $this->filter;
	}
	
	/**
	 * @param string|null $filter
	 *
	 * @return Report
	 */
	public function setFilter(?string $filter): Report
	{
		$this->filter = $filter;
		
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
	 * @return Report
	 */
	public function setCreatedAt(DateTimeInterface $created_at): Report
	{
		$this->created_at = $created_at;
		
		return $this;
	}
}
