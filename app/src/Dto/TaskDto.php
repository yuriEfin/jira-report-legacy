<?php

namespace App\Dto;

class TaskDto
{
	public $id;
	public $jira_key;
	public $status;
	public $actual_time;
	public $plan_time;
	public $release_version;
	public $priority;
	public $created_at;
	public $updated_at;
	public $count_comment;
}