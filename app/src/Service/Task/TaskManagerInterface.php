<?php

namespace App\Service\Task;

use App\Entity\Task;
use App\Entity\User;
use JiraClient\Resource\Issue;

interface TaskManagerInterface
{
	/**
	 * @param Issue      $itemTask
	 * @param User       $user
	 * @param int        $reportId
	 * @param array|null $labels
	 *
	 * @return Task
	 */
	public function create(Issue $itemTask, User $user, int $reportId, ?array $labels = []): Task;
}