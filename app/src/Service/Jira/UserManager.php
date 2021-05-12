<?php


namespace App\Service\Jira;


use App\Dto\User\UserDto;
use App\Entity\Department;
use App\Entity\User;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use App\Service\Jira\Interfaces\ExtractorTaskInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use JiraClient\JiraClient;

class UserManager
{
    private JiraClient $jiraClient;
    private EntityManagerInterface $em;
    private UserRepository $userRepository;
    private DepartmentRepository $departmentRepository;
    
    /**
     * UserManager constructor.
     *
     * @param JiraClient     $jiraClient
     * @param UserRepository $userRepository
     * @param EntityManager  $em
     */
    public function __construct(
        JiraClient $jiraClient,
        UserRepository $userRepository,
        DepartmentRepository $departmentRepository,
        EntityManagerInterface $em
    ) {
        $this->jiraClient = $jiraClient;
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
    }
    
    /**
     * @param UserDto $userDto
     *
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(UserDto $userDto): User
    {
        $user = $this->userRepository->findOneBy(['login' => $userDto->getLogin()]);
        if (!$user) {
            $user = (new User())
                ->setDepartment($this->findUnknownDepartment());
        }
        $user->setLogin($userDto->getLogin())
            ->setCreatedAt($userDto->getCreatedAt())
            ->setName($userDto->getName());
        
        $this->em->persist($user);
        $this->em->flush();
        
        return $user;
    }
    
    /**
     * @return ?Department
     */
    public function findUnknownDepartment(): ?Department
    {
        return $this->departmentRepository->findOneBy(['id' => Department::UNKNOWN]);
    }
}
