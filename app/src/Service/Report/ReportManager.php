<?php

namespace App\Service\Report;

use App\Dto\Notify\TelegramMessageDto;
use App\Dto\User\UserDto;
use App\Entity\Embedded\Priority;
use App\Entity\Embedded\Statuses;
use App\Entity\Embedded\Type;
use App\Entity\Report;
use App\Dto\Report\ReportByDateDto;
use App\Entity\ReportByDate;
use App\Entity\Task;
use App\Repository\DepartmentRepository;
use App\Repository\ReportByDateRepository;
use App\Repository\ReportRepository;
use App\Repository\UserRepository;
use App\Service\Interfaces\ReportManagerInterface;
use App\Service\Jira\Interfaces\IssueManagerInterface;
use App\Service\Jira\IssueConstant;
use App\Service\Jira\UserManager;
use App\Service\Notify\Event\SendReportEvent;
use App\Service\Task\TaskManagerInterface;
use Container6MaxmxK\getDoctrine_Orm_Validator_UniqueService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\Mapping\MappingException;
use JiraClient\Resource\Issue;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Class ReportManager
 */
class ReportManager implements ReportManagerInterface
{
    /**
     * @var ReportRepository
     */
    private $reportRepository;
    /**
     * @var ReportByDateRepository
     */
    private $reportByDateRepository;
    /**
     * @var EntityManagerInterface|EntityManager
     */
    private $em;
    
    private UserManager $userManager;
    private TaskManagerInterface $taskManager;
    private IssueManagerInterface $issueManager;
    private EventDispatcherInterface $eventDispatcher;
    private UserRepository $userRepository;
    private DepartmentRepository $departmentRepository;
    
    public function __construct(
        ReportRepository $reportRepository,
        ReportByDateRepository $reportByDateRepository,
        EntityManagerInterface $em,
        IssueManagerInterface $issueManager,
        UserManager $userManager,
        TaskManagerInterface $taskManager,
        UserRepository $userRepository,
        DepartmentRepository $departmentRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->reportRepository = $reportRepository;
        $this->reportByDateRepository = $reportByDateRepository;
        $this->em = $em;
        
        $this->issueManager = $issueManager;
        $this->userManager = $userManager;
        $this->taskManager = $taskManager;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    /**
     * @param string $name
     * @param string $filter
     *
     * @return Report
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws MappingException
     */
    public function createByFilter(string $name, string $filter): Report
    {
        $report = $this->reportRepository->findOneBy(['filter' => $filter]);
        if (!$report) {
            $report = new Report();
        }
        $report->setName($name);
        $report->setFilter($filter);
        $report->setCreatedAt(new DateTime());
        $this->em->persist($report);
        $this->em->flush();
        
        return $report;
    }
    
    public function createReportByDate(ReportByDateDto $reportByDateDto): ReportByDate
    {
        $reportByDate = $this->reportByDateRepository->findOneBy(
            [
                'report' => $reportByDateDto->getReport(),
                'date'   => date('Y-m-d'),
            ]
        );
        
        if (!$reportByDate) {
            $reportByDate = new ReportByDate();
        }
        
        $reportByDate->setReport($reportByDateDto->getReport())
            ->setCountAll($reportByDateDto->getCountAll())
            ->setDataByUser($reportByDateDto->getDataByUser())
            ->setStatuses(
                (new Statuses())
                    ->setCountTodo($reportByDateDto->getCountTodo())
                    ->setCountProgress($reportByDateDto->getCountProgress())
                    ->setCountPause($reportByDateDto->getCountPause())
                    ->setCountTests($reportByDateDto->getCountTests())
                    ->setCountInTests($reportByDateDto->getCountInTests())
                    ->setCountReopened($reportByDateDto->getCountReopened())
                    ->setCountReview($reportByDateDto->getCountReview())
            )
            ->setPriority(
                (new Priority())
                    ->setCountBlocker($reportByDateDto->getCountBlocker())
                    ->setCountHighest($reportByDateDto->getCountHighest())
                    ->setCountHigh($reportByDateDto->getCountHigh())
                    ->setCountMedium($reportByDateDto->getCountMedium())
                    ->setCountLow($reportByDateDto->getCountLow())
                    ->setCountLowest($reportByDateDto->getCountLowest())
            )->setType(
                (new Type())
                    ->setCountFeature($reportByDateDto->getCountFeature())
                    ->setCountBug($reportByDateDto->getCountBug())
            );
        
        
        $this->em->persist($reportByDate);
        $this->em->flush();
        
        return $reportByDate;
    }
    
    /**
     * @param Report $report
     *
     * @return ReportByDate
     * @throws NonUniqueResultException
     */
    public function formingCommonReport(Report $report): ReportByDate
    {
        $countAll = $this->issueManager->searchTask(rawurldecode($report->getFilter()))->getTotal();
        
        $countBug = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND type IN (Bug,Incident)'))
            ->getTotal();
        $countFeature = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND type IN ("New Feature",Task,Sub-task)'))
            ->getTotal();
        
        $countInProgress = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND status="IN PROGRESS"'))
            ->getTotal();
        
        $countToDo = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND status="TO DO"'))
            ->getTotal();
        
        $countReopen = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND status=REOPENED'))
            ->getTotal();
        
        $countReview = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND status="IN REVIEW"'))
            ->getTotal();
        $countPause = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND status=PAUSE'))
            ->getTotal();
        $countTests = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND status=TEST'))
            ->getTotal();
        
        $countInTests = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND status="IN TEST"'))
            ->getTotal();
        
        $countBlocker = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND priority=Blocker'))
            ->getTotal();
        
        $countHighest = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND priority=Highest'))
            ->getTotal();
        
        $countHigh = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND priority=High'))
            ->getTotal();
        $countMedium = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND priority=Medium'))
            ->getTotal();
        $countLow = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND priority=Low'))
            ->getTotal();
        
        $countLowest = $this->issueManager->searchTask(rawurldecode($report->getFilter() . ' AND priority=Lowest'))
            ->getTotal();
        
        $reportByDate = $this->createReportByDate(
            (new ReportByDateDto())
                ->setCountAll($countAll)
                // statuses
                ->setCountTodo($countToDo)
                ->setCountProgress($countInProgress)
                ->setCountReview($countReview)
                ->setCountReopened($countReopen)
                ->setCountPause($countPause)
                ->setCountTests($countTests)
                ->setCountInTests($countInTests)
                // priority
                ->setCountBlocker($countBlocker)
                ->setCountHighest($countHighest)
                ->setCountHigh($countHigh)
                ->setCountMedium($countMedium)
                ->setCountLow($countLow)
                ->setCountLowest($countLowest)
                // type
                ->setCountBug($countBug)
                ->setCountFeature($countFeature)
                ->setDataByUser(
                    [
                        'countAll'        => $countAll,
                        'countBug'        => $countBug,
                        'countFeature'    => $countFeature,
                        'countInProgress' => $countInProgress,
                        'countToDo'       => $countToDo,
                        'countReopen'     => $countReopen,
                        'countReview'     => $countReview,
                        'countPause'      => $countPause,
                        'countTests'      => $countTests,
                        'countInTests'    => $countInTests,
                        'countBlocker'    => $countBlocker,
                        'countHighest'    => $countHighest,
                        'countHigh'       => $countHigh,
                        'countMedium'     => $countMedium,
                        'countLow'        => $countLow,
                        'countLowest'     => $countLowest,
                    ]
                )
                ->setReport($report)
        );
        
        /** @var ReportByDate $previousReport */
        $previousReport = $this->reportByDateRepository->createQueryBuilder('r')
            ->where('r.report=:report AND r.date < :date')
            ->setParameter('report', $report)
            ->setParameter('date', date('Y-m-d'))
            ->orderBy('r.date', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
        
        $message = '✏️ <u>[' . date('Y-m-d') . '] Отчет ' . $report->getName() . '</u>' . "\n\n";
        $diffCountAll = $previousReport ?
            $countAll - $previousReport->getCountAll() :
            false;
        $message .= '📈 Кол-во задач: <b><u> ' . $countAll . ' </u></b>' .
            ($diffCountAll ? '  (' . (($diffCountAll > 0 ? '❗️+' : '✅') . $diffCountAll) . ')' : '')
            . "\n\n";
        
        $diffBlocker = $previousReport ?
            $reportByDate->getPriority()->getCountBlocker() - $previousReport->getPriority()->getCountBlocker() :
            false;
        $message .= '⛔ Кол-во <u>BLOCKER</u>: <b><u> ' . $reportByDate->getPriority()->getCountBlocker() . ' </u></b>' .
            ($diffBlocker ? '  (' . (($diffBlocker > 0 ? '❗️ +' : '✅') . $diffBlocker) . ')' : '')
            . "\n\n";
        
        $diffBug = $previousReport ?
            $reportByDate->getType()->getCountBug() - $previousReport->getType()->getCountBug() :
            false;
        $message .= '🚫 Кол-во <u>BUG</u>: <b><u> ' . $reportByDate->getType()->getCountBug() . ' </u></b>' .
            ($diffBug ? '  (' . (($diffBug > 0 ? '❗️ +' : '✅') . $diffBug) . ')' : '')
            . "\n\n";
        
        $diffFeature = $previousReport ?
            $reportByDate->getType()->getCountFeature() - $previousReport->getType()->getCountFeature() :
            false;
        $message .= '💹 Кол-во <u>FEATURE</u>: <b><u> ' . $reportByDate->getType()->getCountFeature() . ' </u></b>' .
            ($diffFeature ? '  (' . (($diffFeature > 0 ? '❗️ +' : '✅') . $diffFeature) . ')' : '')
            . "\n\n";
        
        $diffReopened = $previousReport ?
            $reportByDate->getStatuses()->getCountReopened() - $previousReport->getStatuses()->getCountReopened() :
            false;
        $message .= '⭕️ Кол-во <u>REOPENED</u>: <b><u> ' . $reportByDate->getStatuses()->getCountReopened() . ' </u></b>' .
            ($diffReopened ? '  (' . (($diffReopened > 0 ? '❗ +' : '✅') . $diffReopened) . ')' : '')
            . "\n\n";
        
        $diffInReview = $previousReport ?
            $reportByDate->getStatuses()->getCountReview() - $previousReport->getStatuses()->getCountReview() :
            false;
        $message .= '📝 Кол-во <u>REVIEW</u>: <b><u> ' . $reportByDate->getStatuses()->getCountReview() . ' </u></b>' .
            ($diffInReview ? '  (' . (($diffInReview > 0 ? '✅ +' : '❗') . $diffInReview) . ')' : '')
            . "\n\n";
        
        $diffTests = $previousReport ?
            $reportByDate->getStatuses()->getCountTests() - $previousReport->getStatuses()->getCountTests() :
            false;
        $message .= '✅ Кол-во <u>TESTS</u>: <b><u> ' . $reportByDate->getStatuses()->getCountTests() . ' </u></b>' .
            ($diffTests ? '  (' . (($diffTests > 0 ? '🤞 +' : '❗') . $diffTests) . ')' : '')
            . "\n\n";
        
        $diffInTests = $previousReport ?
            $reportByDate->getStatuses()->getCountInTests() - $previousReport->getStatuses()->getCountInTests() :
            false;
        $message .= '🔆 Кол-во <u>IN TESTS</u>: <b><u> ' . $reportByDate->getStatuses()->getCountInTests() . ' </u></b>' .
            ($diffInTests ? '  (' . (($diffInTests > 0 ? '✅ +' : '❗') . $diffInTests) . ')' : '')
            . "\n\n";
        
        
        $this->eventDispatcher->dispatch(
            new SendReportEvent(
                [
                    $message,
                ],
            ),
            SendReportEvent::NAME
        );
        
        return $reportByDate;
    }
    
    /**
     * @throws OptimisticLockException
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function formingReportByUser(Report $report): void
    {
        $users = $this->userRepository->findBy(
            [
                'department' => [
                    $this->departmentRepository->find(1),
                    $this->departmentRepository->find(2),
                ],
            ]
        );
        $fetchTaskCallback = static function (\Iterator $tasksResponse) {
            $stack = [];
            $stack['allTasks'] = [];
            while ($tasksResponse->valid()) {
                /** @var Issue $task */
                $task = $tasksResponse->current();
                $stack['allTasks'][] = $task;
                $stack[$task->getPriority()->getName()][] = $task;
                $stack[$task->getStatus()->getName()][] = $task;
                $stack[$task->getIssueType()->getName()][] = $task;
                
                $tasksResponse->next();
            }
            
            return $stack;
        };
        
        foreach ($users as $user) {
            $filter = rawurldecode($report->getFilter() . ' AND assignee=' . $user->getLogin());
            $reportByUser = $this->createByFilter('<b><u>' . $report->getName() . '</u></b>' . ' ' . $user->getTelegramLogin(), $filter);
            
            $searchTaskUserResponse = $this->issueManager->searchTask($filter);
            $countAll = $searchTaskUserResponse->getTotal();
            
            $stackTask = $fetchTaskCallback($searchTaskUserResponse);
            $tasksUser = [];
            /** @var Issue $itemTask */
            foreach ($stackTask['allTasks'] ?? [] as $itemTask) {
                $userDto = new UserDto();
                $userDto->setName($itemTask->getAssignee()->getDisplayName())
                    ->setCreatedAt(new \DateTime())
                    ->setLogin($itemTask->getAssignee()->getName());
                
                $user = $this->userManager->create($userDto);
                
                /** @var Task $task */
                $task = $this->taskManager->create($itemTask, $user, $reportByUser->getId(), [$reportByUser->getName()]);
                
                $tasksUser[$this->formingKeyPriority($task)][] = $this->formingItemTask($task, $itemTask);
            }
            
            $reportByDate = $this->createReportByDate(
                (new ReportByDateDto())
                    ->setCountAll($countAll)
                    // statuses
                    ->setCountTodo(count($stackTask[IssueConstant::ISSUE_STATUS_TODO] ?? []))
                    ->setCountProgress(count($stackTask[IssueConstant::ISSUE_STATUS_IN_PROGRESS] ?? []))
                    ->setCountReview(count($stackTask[IssueConstant::ISSUE_STATUS_IN_REVIEW] ?? []))
                    ->setCountReopened(count($stackTask[IssueConstant::ISSUE_STATUS_REOPENED] ?? []))
                    ->setCountPause(count($stackTask[IssueConstant::ISSUE_STATUS_PAUSE] ?? []))
                    ->setCountTests(count($stackTask[IssueConstant::ISSUE_STATUS_TESTS] ?? []))
                    ->setCountInTests(count($stackTask[IssueConstant::ISSUE_STATUS_IN_TESTS] ?? []))
                    // priority
                    ->setCountBlocker(count($stackTask[IssueConstant::ISSUE_PRIORITY_BLOCKER] ?? []))
                    ->setCountHighest(count($stackTask[IssueConstant::ISSUE_PRIORITY_HIGHEST] ?? []))
                    ->setCountHigh(count($stackTask[IssueConstant::ISSUE_PRIORITY_HIGH] ?? []))
                    ->setCountMedium(count($stackTask[IssueConstant::ISSUE_PRIORITY_MEDIUM] ?? []))
                    ->setCountLow(count($stackTask[IssueConstant::ISSUE_PRIORITY_LOW] ?? []))
                    ->setCountLowest(count($stackTask[IssueConstant::ISSUE_PRIORITY_LOWEST] ?? []))
                    // type
                    ->setCountBug(count($stackTask[IssueConstant::ISSUE_TYPE_BUG] ?? []))
                    ->setCountFeature(count($stackTask[IssueConstant::ISSUE_TYPE_NEW_FEATURE] ?? []))
                    // list tasks by user
                    ->setReport($reportByUser)
            );
            
            if ($tasksUser) {
                $message = '🚩 ' . $reportByUser->getName() . ' (' . date('Y-m-d') . '):' . "\n";
                if ($reportByDate->getPriority()->getCountBlocker()) {
                    $message .= "\n" . 'Кол-во ⛔ <b><u>Blocker</u></b>: ' . $reportByDate->getPriority()->getCountBlocker() . "\n";
                }
                if ($reportByDate->getPriority()->getCountHighest()) {
                    $message .= "\n" . 'Кол-во 🔥 <b><u>Highest</u></b>: ' . $reportByDate->getPriority()->getCountHighest() . "\n";
                }
                if ($reportByDate->getPriority()->getCountHigh()) {
                    $message .= "\n" . 'Кол-во 💥 <b><u>High</u></b>: ' . $reportByDate->getPriority()->getCountHigh() . "\n";
                }
                if ($reportByDate->getPriority()->getCountMedium()) {
                    $message .= "\n" . 'Кол-во ⚡️<b><u>Medium</u></b>: ' . $reportByDate->getPriority()->getCountMedium() . "\n";
                }
                if ($reportByDate->getPriority()->getCountLow()) {
                    $message .= "\n" . 'Кол-во 🔆️ <b><u>Low</u></b>: ' . $reportByDate->getPriority()->getCountLow() . "\n";
                }
                if ($reportByDate->getPriority()->getCountLowest()) {
                    $message .= "\n" . 'Кол-во 🔅 <b><u>Lowest</u></b>: ' . $reportByDate->getPriority()->getCountLowest() . "\n";
                }
                $message .= "\n =============================== \n";
                
                foreach ($tasksUser as $priority => $tasks) {
                    $message .= "\n\n<b><u>" . $priority . "</u></b>\n\n";
                    $message .= implode("\n\n", $tasks);
                }
                
                $this->eventDispatcher->dispatch(
                    new SendReportEvent(
                        [
                            $message,
                        ]
                    ),
                    SendReportEvent::NAME
                );
            }
        }
    }
    
    /**
     * @param Report   $report
     * @param string[] $priorities
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function formingReportByPriority(Report $report, array $priorities = [IssueConstant::ISSUE_PRIORITY_BLOCKER]): void
    {
        $fetchTaskCallback = static function (\Iterator $tasksResponse) {
            $stack = [];
            while ($tasksResponse->valid()) {
                /** @var Issue $task */
                $task = $tasksResponse->current();
                if ($task->getPriority()->getName() === IssueConstant::ISSUE_PRIORITY_BLOCKER) {
                    $stack[$task->getPriority()->getName()][] = $task;
                }
                if ($task->getStatus()->getName() === IssueConstant::ISSUE_STATUS_PAUSE) {
                    $stack[$task->getStatus()->getName()][] = $task;
                }
                
                $tasksResponse->next();
            }
            
            return $stack;
        };
        
        foreach ($priorities as $priority) {
            $filter = rawurldecode($report->getFilter() . ' AND priority=' . $priority);
            $reportByPriority = $this->createByFilter('<b><u>' . $report->getName() . '</u></b>' . ' ' . $priority, $filter);
            
            $searchTaskUserResponse = $this->issueManager->searchTask($filter);
            
            $stackTask = $fetchTaskCallback($searchTaskUserResponse);
            
            $tasksPriority = [];
            /** @var Issue $itemTask */
            foreach ($stackTask as $itemsTask) {
                foreach ($itemsTask as $itemTask) {
                    $userDto = new UserDto();
                    $userDto->setName($itemTask->getAssignee()->getDisplayName())
                        ->setCreatedAt(new \DateTime())
                        ->setLogin($itemTask->getAssignee()->getName());
                    
                    $user = $this->userManager->create($userDto);
                    
                    /** @var Task $task */
                    $task = $this->taskManager->create($itemTask, $user, $reportByPriority->getId(), [$reportByPriority->getName()]);
                    
                    $tasksPriority[$reportByPriority->getName() . "\n\n" . $this->formingKeyPriority($task)][]
                        = $this->formingItemTask($task, $itemTask, true);
                }
            }
            
            if ($tasksPriority) {
                foreach ($tasksPriority as $priority => $tasks) {
                    $message = "\n\n<b><u>" . $priority . "</u></b>\n\n";
                    $message .= implode("\n\n", $tasks);
                    
                    $this->eventDispatcher->dispatch(
                        new SendReportEvent(
                            [
                                $message,
                            ]
                        ),
                        SendReportEvent::NAME
                    );
                }
            }
        }
    }
    
    
    /**
     * @param Report   $report
     * @param string[] $statuses
     *
     * @throws MappingException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function formingReportByStatus(Report $report, array $statuses = [IssueConstant::ISSUE_STATUS_PAUSE, IssueConstant::ISSUE_STATUS_REOPENED]): void
    {
        $fetchTaskCallback = static function (\Iterator $tasksResponse) {
            $stack = [];
            while ($tasksResponse->valid()) {
                /** @var Issue $task */
                $task = $tasksResponse->current();
                if ($task->getPriority()->getName() === IssueConstant::ISSUE_PRIORITY_BLOCKER) {
                    $stack[$task->getPriority()->getName()][] = $task;
                }
                if ($task->getStatus()->getName() === IssueConstant::ISSUE_STATUS_PAUSE) {
                    $stack[$task->getStatus()->getName()][] = $task;
                }
                
                $tasksResponse->next();
            }
            
            return $stack;
        };
        
        foreach ($statuses as $status) {
            $filter = rawurldecode($report->getFilter() . ' AND status=' . $status);
            $reportByPriority = $this->createByFilter('<b><u>' . $report->getName() . '</u></b>' . ' ' . $status, $filter);
            
            $searchTaskUserResponse = $this->issueManager->searchTask($filter);
            
            $stackTask = $fetchTaskCallback($searchTaskUserResponse);
            
            $tasksStatuses = [];
            /** @var Issue $itemTask */
            foreach ($stackTask as $status => $itemsTask) {
                foreach ($itemsTask as $itemTask) {
                    $userDto = new UserDto();
                    $userDto->setName($itemTask->getAssignee()->getDisplayName())
                        ->setCreatedAt(new \DateTime())
                        ->setLogin($itemTask->getAssignee()->getName());
                    
                    $user = $this->userManager->create($userDto);
                    
                    /** @var Task $task */
                    $task = $this->taskManager->create($itemTask, $user, $reportByPriority->getId(), [$reportByPriority->getName()]);
    
                    $tasksStatuses[$reportByPriority->getName() . "\n\n" . $this->formingKeyPriority($task)][]
                        = $this->formingItemTask($task, $itemTask, true);
                }
            }
            
            if ($tasksStatuses) {
                foreach ($tasksStatuses as $status => $tasks) {
                    $message = "\n\n<b><u>" . $status . "</u></b>\n\n";
                    $message .= implode("\n\n", $tasks);
                    
                    $this->eventDispatcher->dispatch(
                        new SendReportEvent(
                            [
                                $message,
                            ]
                        ),
                        SendReportEvent::NAME
                    );
                }
            }
        }
    }
    
    private function formingKeyPriority(Task $task)
    {
        $priority = $task->getPriority();
        switch ($priority) {
            case IssueConstant::ISSUE_PRIORITY_BLOCKER:
                $val = '⛔️' . $priority;
                break;
            case IssueConstant::ISSUE_PRIORITY_HIGHEST:
                $val = '🔥️ ' . $priority;
                break;
            case IssueConstant::ISSUE_PRIORITY_HIGH:
                $val = '💥️ ' . $priority;
                break;
            case IssueConstant::ISSUE_PRIORITY_MEDIUM:
                $val = '⚡️' . $priority;
                break;
            case IssueConstant::ISSUE_PRIORITY_LOW :
                $val = '🔆️ ' . $priority;
                break;
            case IssueConstant::ISSUE_PRIORITY_LOWEST:
                $val = '🔅 ️' . $priority;
                break;
        }
        
        return $val;
    }
    
    /**
     * @param Task  $task
     * @param Issue $itemTask
     * @param bool  $isAppendUser
     *
     * @return string
     */
    private function formingItemTask(Task $task, Issue $itemTask, bool $isAppendUser = false)
    {
        if ($isAppendUser) {
            return sprintf(
                '<a href="' . $this->createLink($task->getJiraKey()) . '">%s</a> - %s (%s, %s, %s)',
                $task->getJiraKey(),
                mb_substr($itemTask->getSummary(), 0, 300),
                $itemTask->getStatus()->getName(),
                $task->getUser()->getTelegramLogin(),
                implode(
                    ' | ',
                    array_map(
                        static function (array $item) {
                            return $item['name'];
                        },
                        $itemTask->getComponents()
                    )
                ),
            );
        }
        
        return sprintf(
            '<a href="' . $this->createLink($task->getJiraKey()) . '">%s</a> - %s (%s, %s)',
            $task->getJiraKey(),
            mb_substr($itemTask->getSummary(), 0, 300),
            $itemTask->getStatus()->getName(),
            $itemTask->getPriority()->getName(),
        );
    }
    
    public function update($id): Report
    {
    }
    
    public function delete($id): bool
    {
    }
    
    public function findById($id): ?Report
    {
        return $this->reportRepository->findOneBy(['id' => $id]);
    }
    
    /**
     * @param string $key
     *
     * @return string
     */
    private function createLink(string $key): string
    {
        return sprintf('https://jira.dev-og.com/browse/%s', $key);
    }
}
