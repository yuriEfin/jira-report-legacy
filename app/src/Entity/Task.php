<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
	private const DEFAULT_REPORT = 9999999;
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private ?string $jira_key;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private ?string $jira_parent_key;
	
	/**
	 * @ORM\Column(type="string", length=255)
	 */
	private ?string $status;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private ?int $actual_time;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private ?int $plan_time;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private ?string $release_version;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private ?string $priority;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	private ?\DateTimeInterface $created_at;
	
	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private ?\DateTimeInterface $updated_at;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	private ?int $count_comment;
	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 */
	private ?User $user;
	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private ?string $label;
	/**
	 * @ORM\Column(type="integer", nullable=false)
	 */
	private int $report_id = self::DEFAULT_REPORT;
	
	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param mixed $id
	 *
	 * @return Task
	 */
	public function setId($id)
	{
		$this->id = $id;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getJiraKey(): ?string
	{
		return $this->jira_key;
	}
	
	/**
	 * @param string|null $jira_key
	 *
	 * @return Task
	 */
	public function setJiraKey(?string $jira_key): Task
	{
		$this->jira_key = $jira_key;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getJiraParentKey(): ?string
	{
		return $this->jira_parent_key;
	}
	
	/**
	 * @param string|null $jira_parent_key
	 *
	 * @return Task
	 */
	public function setJiraParentKey(?string $jira_parent_key): Task
	{
		$this->jira_parent_key = $jira_parent_key;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getStatus(): ?string
	{
		return $this->status;
	}
	
	/**
	 * @param string|null $status
	 *
	 * @return Task
	 */
	public function setStatus(?string $status): Task
	{
		$this->status = $status;
		
		return $this;
	}
	
	/**
	 * @return int|null
	 */
	public function getActualTime(): ?int
	{
		return $this->actual_time;
	}
	
	/**
	 * @param int|null $actual_time
	 *
	 * @return Task
	 */
	public function setActualTime(?int $actual_time): Task
	{
		$this->actual_time = $actual_time;
		
		return $this;
	}
	
	/**
	 * @return int|null
	 */
	public function getPlanTime(): ?int
	{
		return $this->plan_time;
	}
	
	/**
	 * @param int|null $plan_time
	 *
	 * @return Task
	 */
	public function setPlanTime(?int $plan_time): Task
	{
		$this->plan_time = $plan_time;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getReleaseVersion(): ?string
	{
		return $this->release_version;
	}
	
	/**
	 * @param string|null $release_version
	 *
	 * @return Task
	 */
	public function setReleaseVersion(?string $release_version): Task
	{
		$this->release_version = $release_version;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getPriority(): ?string
	{
		return $this->priority;
	}
	
	/**
	 * @param string|null $priority
	 *
	 * @return Task
	 */
	public function setPriority(?string $priority): Task
	{
		$this->priority = $priority;
		
		return $this;
	}
	
	/**
	 * @return \DateTimeInterface|null
	 */
	public function getCreatedAt(): ?\DateTimeInterface
	{
		return $this->created_at;
	}
	
	/**
	 * @param \DateTimeInterface|null $created_at
	 *
	 * @return Task
	 */
	public function setCreatedAt(?\DateTimeInterface $created_at): Task
	{
		$this->created_at = $created_at;
		
		return $this;
	}
	
	/**
	 * @return \DateTimeInterface|null
	 */
	public function getUpdatedAt(): ?\DateTimeInterface
	{
		return $this->updated_at;
	}
	
	/**
	 * @param \DateTimeInterface|null $updated_at
	 *
	 * @return Task
	 */
	public function setUpdatedAt(?\DateTimeInterface $updated_at): Task
	{
		$this->updated_at = $updated_at;
		
		return $this;
	}
	
	/**
	 * @return int|null
	 */
	public function getCountComment(): ?int
	{
		return $this->count_comment;
	}
	
	/**
	 * @param int|null $count_comment
	 *
	 * @return Task
	 */
	public function setCountComment(?int $count_comment): Task
	{
		$this->count_comment = $count_comment;
		
		return $this;
	}
	
	/**
	 * @return User|null
	 */
	public function getUser(): ?User
	{
		return $this->user;
	}
	
	/**
	 * @param User|null $user
	 *
	 * @return Task
	 */
	public function setUser(?User $user): Task
	{
		$this->user = $user;
		
		return $this;
	}
	
	/**
	 * @return string|null
	 */
	public function getLabel(): ?string
	{
		return $this->label;
	}
	
	/**
	 * @param string|null $label
	 *
	 * @return Task
	 */
	public function setLabel(?string $label): Task
	{
		$this->label = $label;
		
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getReportId(): int
	{
		return $this->report_id;
	}
	
	/**
	 * @param int $report_id
	 *
	 * @return Task
	 */
	public function setReportId(int $report_id): Task
	{
		$this->report_id = $report_id;
		
		return $this;
	}
}