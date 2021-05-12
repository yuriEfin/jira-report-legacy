<?php


namespace App\Service\Jira;

use App\Service\Jira\Interfaces\ExtractorTaskInterface;

/**
 * Class ExtractorTask
 */
class ExtractorTask implements ExtractorTaskInterface
{
    public function extractByFile(string $filePath, string $prefixTask = '')
    {
        $fileContent = file_get_contents(realpath($filePath));
        
        preg_match_all('/[A-z]+\-\d+/', $fileContent, $matches);
        
        if ($prefixTask) {
            return array_filter(
                $matches[0],
                static function (string $taskKey) use ($prefixTask) {
                    return preg_match('/' . $prefixTask . '/', $taskKey);
                }
            );
        }
        
        return array_filter($matches[0]);
    }
}
