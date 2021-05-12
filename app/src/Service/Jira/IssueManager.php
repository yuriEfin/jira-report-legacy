<?php

namespace App\Service\Jira;

use App\Dto\Issue\IssueDto;
use App\Service\Jira\Interfaces\IssueManagerInterface;
use App\Service\Jira\Interfaces\ExtractorTaskInterface;
use JiraClient\JiraClient;
use JiraClient\Resource\Field;
use Exception;
use JiraClient\Resource\Issue as JiraIssue;

/**
 * Class IssueManager
 */
class IssueManager implements IssueManagerInterface
{
	/**
	 * @var JiraClient
	 */
	private $jiraClient;
	/**
	 * @var ExtractorTaskInterface|ExtractorTask
	 */
	private $extractorTask;
	
	/**
	 * IssueManager constructor.
	 *
	 * @param JiraClient             $issueService
	 * @param ExtractorTaskInterface $extractorTask
	 */
	public function __construct(JiraClient $issueService, ExtractorTaskInterface $extractorTask)
	{
		$this->jiraClient = $issueService;
		$this->extractorTask = $extractorTask;
	}
	
	/**
	 * @param string $key
	 * @param array  $params
	 *
	 * @return JiraIssue|null
	 */
	public function getTask(string $key, array $params = []): ?JiraIssue
	{
		try {
			return $this->jiraClient->issue()->get($key, $params);
		} catch (Exception $exception) {
			return null;
		}
	}
	
	/**
	 * @param string   $pathFile
	 * @param IssueDto $issueDto
	 * @param string   $prefixTask
	 *
	 * @return array
	 * @throws Exception
	 */
	public function updateWithFile(string $pathFile, IssueDto $issueDto, $isWithSubTask = false, $isOnlySubTask = false)
	{
		$tasks = $this->extractorTask->extractByFile($pathFile, $issueDto->getIssueSearchPrefix());
		
		$response = [];
		foreach ($tasks as $taskId) {
			$response[$taskId] = $this->update($taskId, $issueDto, $isWithSubTask, $isOnlySubTask);
		}
		
		return $response;
	}
	
	/**
	 * @param string   $issueKey
	 * @param IssueDto $issueDto
	 *
	 * @return bool
	 */
	public function update(string $issueKey, IssueDto $issueDto, $isWithSubTask = false, $isOnlySubTask = false): bool
	{
		$task = $this->getTask(
			$issueKey,
			[]
		);
		file_put_contents('/var/www/var/data/task/list-moloko-search.txt', print_r($task, true));
		die;
		if (!$task) {
			return false;
		}
		
		$taskUpdater = $task->update();
		
		if ($issueDto->getLabel()) {
			$taskUpdater->field(Field::LABELS, $issueDto->getLabel());
		}
		if ($issueDto->getComponent()) {
			$taskUpdater->field(Field::COMPONENT, $issueDto->getComponent());
		}
		if ($issueDto->getFixVersion()) {
			$taskUpdater
				->field('fixVersions', [$task->getFixVersions(), $issueDto->getFixVersion()]);
		}
		
		if ($issueDto->getAssigneeName()) {
			$taskUpdater->field(Field::ASSIGNEE, $issueDto->getAssigneeName());
		}
		if ($issueDto->getComment()) {
			$taskUpdater->field('comment', $issueDto->getComment());
		}
		
		if ($issueDto->getPriority()) {
			$taskUpdater->field(Field::PRIORITY, $issueDto->getPriority());
		}
		if ($issueDto->getSummary()) {
			$taskUpdater->field(Field::SUMMARY, $issueDto->getSummary());
		}
		$ret = $taskUpdater->execute();
		
		if ($status = $issueDto->getStatus()) {
			$workflowData = $this->getWorkflowSchemeByTask($issueDto->getIssueKey());
			$workflowKey = ($workflowData[$status] ?? null);
			if ($workflowKey) {
				$task->transition()->execute($workflowKey['id']);
			}
		}
		
		return true;
	}
	
	public function getWorkflowSchemeByTask(string $taskId): array
	{
		$workflow = $this->jiraClient->callGet('/issue/' . $taskId . '/transitions');
		
		$data = [];
		foreach ($workflow->getData()['transitions'] as $item) {
			if (!isset($item['id'], $item['name'])) {
				continue;
			}
			
			$name = strtoupper($item['name']);
			$id = $item['id'];
			$data[$name] = [
				'id'   => (int)$id,
				'name' => $name,
			];
		}
		
		return $data;
	}
	
	public function searchTask(string $filter)
	{
		return $this->jiraClient->issue()->search($filter);
	}
	
	public function createTask()
	{
	}
}