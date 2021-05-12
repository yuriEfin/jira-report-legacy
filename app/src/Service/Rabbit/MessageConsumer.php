<?php

namespace App\Service\Rabbit;

use App\Entity\Task;
use App\Service\Interfaces\ReportManagerInterface;
use App\Service\Jira\Interfaces\IssueManagerInterface;
use App\Service\Jira\IssueConstant;
use JiraClient\Resource\Issue;
use PhpAmqpLib\Message\AMQPMessage;

class MessageConsumer
{
	private ReportManagerInterface $reportManager;
	private IssueManagerInterface $issueManager;
	
	/**
	 * MessageConsumer constructor.
	 *
	 * @param ReportManagerInterface $reportManager
	 */
	public function __construct(ReportManagerInterface $reportManager, IssueManagerInterface $issueManager)
	{
		$this->reportManager = $reportManager;
		$this->issueManager = $issueManager;
	}
	
	public function execute(AMQPMessage $msg)
	{
		$message = json_decode($msg->body, true);
		$report = $this->reportManager->createByFilter($message['name'], $message['filter']);
		
		$searchTaskResponse = $this->issueManager->searchTask($report->getFilter());
		
		$fetchTaskCallback = function (\Iterator $tasksResponse) {
			$stack = [];
			while ($tasksResponse->valid()) {
				/** @var Issue $task */
				$stack[] = $tasksResponse->current();
				
				$tasksResponse->next();
			}
			
			return $stack;
		};
		
		$stackTask = [];
		while ($searchTaskResponse->valid()) {
			$key = $searchTaskResponse->key();
			/** @var Issue $task */
			$currentTask = $searchTaskResponse->current();
			
			// если тип Story - получить все sub-tasks
			// если тип таск или саб таск - записываем таску в таблицу task с закреплением за пользователем
			/** @var Issue $currentTask */
			if ($currentTask->getIssueType()->getName() === IssueConstant::ISSUE_TYPE_STORY) {
				$subTasks = $this->issueManager->searchTask(sprintf('parent=%s', $currentTask->getId()));
				$stackTask = array_merge($stackTask, $fetchTaskCallback($subTasks));
			} else {
				$stackTask[] = $currentTask;
			}
			
			$searchTaskResponse->next();
		}
		/** @var Issue $itemTask */
		foreach ($stackTask as $itemTask) {
			var_dump($currentTask->getAssignee()->getName(), '$itemTask');
		}
	}
}