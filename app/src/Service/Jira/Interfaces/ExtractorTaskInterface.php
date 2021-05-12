<?php

namespace App\Service\Jira\Interfaces;

/**
 * Class ExtractorTaskInterface
 */
interface ExtractorTaskInterface
{
    public function extractByFile(string $filePath, string $prefixTask = '');
}
