<?php

namespace App\Service\Jira\Interfaces;

interface IssueReleaseManagerInterface
{
    public function search(string $version);
}
