<?php

namespace App\Service\Jira;

/**
 * Class IssueConstant
 */
class IssueConstant
{
    // types
    public const ISSUE_TYPE_STORY = 'Story';
    public const ISSUE_TYPE_TASK = 'Task';
    public const ISSUE_TYPE_SUB_TASK = 'Sub-task';
    public const ISSUE_TYPE_BUG = 'Bug';
    public const ISSUE_TYPE_INCIDENT = 'Incident';
    public const ISSUE_TYPE_NEW_FEATURE = 'New Feature';
    public const ISSUE_TYPE_IMPROVEMENT = 'Improvement';
    
    // priority
    public const ISSUE_PRIORITY_BLOCKER = 'Blocker';
    public const ISSUE_PRIORITY_HIGHEST = 'Highest';
    public const ISSUE_PRIORITY_HIGH = 'High';
    public const ISSUE_PRIORITY_MEDIUM = 'Medium';
    public const ISSUE_PRIORITY_LOW = 'Low';
    public const ISSUE_PRIORITY_LOWEST = 'Lowest';
    
    // status
    public const ISSUE_STATUS_TODO = 'TO DO';
    public const ISSUE_STATUS_PAUSE = 'PAUSE';
    public const ISSUE_STATUS_CLOSED = 'CLOSED';
    public const ISSUE_STATUS_CANCELED = 'CANCELED';
    public const ISSUE_STATUS_IN_PROGRESS = 'IN PROGRESS';
    public const ISSUE_STATUS_REOPENED = 'REOPENED';
    public const ISSUE_STATUS_TESTS = 'TESTS';
    public const ISSUE_STATUS_IN_TESTS = 'IN TEST';
    public const ISSUE_STATUS_IN_REVIEW = 'IN REVIEW';
    
    // department
    public const ISSUE_DEPARTMENT_BE = 'BE';
    public const ISSUE_DEPARTMENT_FE = 'FE';
    public const ISSUE_DEPARTMENT_TEST = 'TEST';
}
