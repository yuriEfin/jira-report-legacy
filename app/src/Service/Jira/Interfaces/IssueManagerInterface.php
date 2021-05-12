<?php

namespace App\Service\Jira\Interfaces;

interface IssueManagerInterface
{
	public function getTask(string $key, array $params = []);
	
	public function searchTask(string $filter);
}
