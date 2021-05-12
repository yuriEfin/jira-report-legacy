<?php

namespace App\Command;

use App\Dto\Notify\TelegramMessageDto;
use App\Entity\User;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use App\Service\Jira\Interfaces\IssueManagerInterface;
use App\Service\Interfaces\ReportManagerInterface;
use App\Service\Jira\IssueManager;
use App\Service\Jira\UserManager;
use App\Service\Notify\TelegramNotify;
use App\Service\Rabbit\Interfaces\MessageServiceInterface;
use App\Service\Task\TaskManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ReportJiraCommand extends Command
{
    protected static $defaultName = 'jira-report';
    
    private ReportManagerInterface $reportManager;
    private MessageServiceInterface $messageService;
    private UserRepository $userRepository;
    private DepartmentRepository $departmentRepository;
    private TelegramNotify $telegramNotify;
    
    /**
     * ReportJiraCommand constructor.
     *
     * @param string|null             $name
     * @param MessageServiceInterface $messageService
     * @param ReportManagerInterface  $reportManager
     */
    public function __construct(
        string $name = null,
        MessageServiceInterface $messageService,
        ReportManagerInterface $reportManager,
        UserRepository $userRepository,
        DepartmentRepository $departmentRepository,
        TelegramNotify $telegramNotify
    ) {
        $this->messageService = $messageService;
        $this->reportManager = $reportManager;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
        $this->telegramNotify = $telegramNotify;
        
        parent::__construct($name);
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Отчеты')
            ->addOption('excludeStatus', 'excludeStatus', InputArgument::OPTIONAL, 'Игнорировать таски в статусах...')
            ->addOption('id', 'id', InputArgument::OPTIONAL, 'Report ID')
            ->addOption('name', 'name', InputArgument::OPTIONAL, 'Report name')
            ->addOption('filter', 'f', InputArgument::OPTIONAL, 'JQL filter')
            ->addOption('components', 'comp', InputArgument::OPTIONAL, 'JQL filter components');
    }
    
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $ignoreStatuses = array_map(
            function ($status) {
                return trim($status);
            },
            explode(',', $input->getOption('excludeStatus'))
        );
        $id = $input->getOption('id');
        if ($id) {
            $report = $this->reportManager->findById($id);
            $name = $report->getName();
            $filter = rawurldecode($report->getFilter());
        } else {
            $name = $input->getOption('name');
            $filter = rawurldecode($input->getOption('filter'));
        }
        
        if ($components = $input->getOption('components')) {
            $departments = $this->departmentRepository->findBy(['name' => explode(',', $components)]);
            $users = $this->userRepository->findBy(['department' => $departments]);
            
            if (!empty($users)) {
                $userLoginList = array_map(
                    static function (User $user) {
                        return $user->getLogin();
                    },
                    $users
                );
                
                $filter .= ' AND assignee IN (' . implode(',', $userLoginList) . ')';
            }
        }
        $report = $this->reportManager->createByFilter($name, $filter);
        
        $this->reportManager->formingCommonReport($report);
        $this->reportManager->formingReportByUser($report);
        $this->reportManager->formingReportByPriority($report);
        
        return Command::SUCCESS;
    }
    
    // Количество Story без сабтасков - не расписанные Story
}
