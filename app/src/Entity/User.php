<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    public const UNKNOWN = 'Unknown';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $name = 'Unknown';
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $username = 'Unknown';
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $login = 'Unknown';
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $telegramLogin = 'Unknown';
    
    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="id")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id", nullable=true, columnDefinition="INT DEFAULT 6")
     */
    private ?Department $department;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTimeInterface $created_at;
    
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
     * @return User
     */
    public function setId($id): User
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
     * @return User
     */
    public function setName(?string $name): User
    {
        $this->name = $name;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }
    
    /**
     * @param string|null $username
     *
     * @return User
     */
    public function setUsername(?string $username): User
    {
        $this->username = $username;
        
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
     * @param string|null $login
     *
     * @return User
     */
    public function setLogin(?string $login): User
    {
        $this->login = $login;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getTelegramLogin(): ?string
    {
        return $this->telegramLogin;
    }
    
    /**
     * @param string|null $telegramLogin
     *
     * @return User
     */
    public function setTelegramLogin(?string $telegramLogin): User
    {
        $this->telegramLogin = $telegramLogin;
        
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
     * @return User
     */
    public function setCreatedAt(?DateTimeInterface $created_at): User
    {
        $this->created_at = $created_at;
        
        return $this;
    }
    
    /**
     * @return Department
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }
    
    /**
     * @param Department $department
     *
     * @return User
     */
    public function setDepartment(Department $department): User
    {
        $this->department = $department;
        
        return $this;
    }
}
