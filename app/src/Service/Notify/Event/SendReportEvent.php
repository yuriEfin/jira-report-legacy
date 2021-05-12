<?php

namespace App\Service\Notify\Event;

use App\Entity\Report;
use App\Entity\ReportByDate;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SendReportEvent
 */
class SendReportEvent extends Event
{
    public const NAME = 'jira.report.ready';
    
    private array $report;
    private array $result = [];
    
    /**
     * SendReportEvent constructor.
     *
     * @param array $report
     */
    public function __construct(array $report)
    {
        $this->report = $report;
    }
    
    /**
     * @return array
     */
    final public function getReport(): array
    {
        return $this->report;
    }
    
    /**
     * @param array $result
     */
    final public function setResult(array $result): void
    {
        if (!is_array($this->getResult())) {
            $this->result = [];
        }
        $this->result = array_merge($this->result, $result);
    }
    
    /**
     * @return array
     */
    final public function getResult(): array
    {
        return $this->result ?? [];
    }
}
