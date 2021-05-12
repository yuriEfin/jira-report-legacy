<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use JiraClient\Resource\Issue;
use JiraClient\Resource\Version;

class TaskManager implements TaskManagerInterface
{
	private TaskRepository $taskRepository;
	private EntityManagerInterface $em;
	
	/**
	 * TaskManager constructor.
	 *
	 * @param TaskRepository         $taskRepository
	 * @param EntityManagerInterface $em
	 */
	public function __construct(TaskRepository $taskRepository, EntityManagerInterface $em)
	{
		$this->taskRepository = $taskRepository;
		$this->em = $em;
	}
	
	/**
	 * @param Issue      $itemTask
	 * @param User       $user
	 * @param array|null $labels
	 *
	 * @return Task
	 */
	public function create(Issue $itemTask, User $user, int $reportId, ?array $labels = []): Task
	{
		$task = $this->taskRepository->findOneBy(['jira_key' => $itemTask->getKey()]);
		if (!$task) {
			$task = new Task();
		}
		
		$task->setJiraKey($itemTask->getKey())
			->setCreatedAt($itemTask->getCreated())
			->setActualTime($itemTask->getTimeOriginalEstimate())
			->setPriority($itemTask->getPriority()->getName())
			->setReleaseVersion(
				implode(
					',',
					array_map(
						function (Version $it) use ($itemTask) {
							return $it->getName();
						},
						$itemTask->getFixVersions()
					)
				)
			)
			->setCountComment($itemTask->getComments()->getTotal())
			->setStatus($itemTask->getStatus()->getName())
			->setUser($user)
			->setReportId($reportId)
			->setLabel(implode(',', array_merge($itemTask->getLabels(), $labels)));
		
		$this->em->persist($task);
		$this->em->flush();
		
		return $task;
	}
}
