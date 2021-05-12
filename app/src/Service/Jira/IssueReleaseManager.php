<?php

namespace App\Service\Jira;

use App\Service\Jira\Interfaces\IssueManagerInterface;
use App\Service\Jira\Interfaces\IssueReleaseManagerInterface;
use JiraClient\JiraClient;
use JiraClient\Response as JiraResponse;

class IssueReleaseManager implements IssueReleaseManagerInterface
{
    /**
     * @var JiraClient
     */
    private $jiraClient;
    
    /**
     * IssueReleaseManager constructor.
     *
     * @param JiraClient $jiraClient
     */
    public function __construct(JiraClient $jiraClient, IssueManagerInterface $issueManager)
    {
        $this->jiraClient = $jiraClient;
        $this->issueManager = $issueManager;
    }
    
    public function search(string $version)
    {
        return $this->issueManager->searchTask(
            sprintf('(fixVersion =%s OR affectedVersion =%s)', $version, $version)
        );
    }
}
