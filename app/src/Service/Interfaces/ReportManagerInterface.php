<?php

namespace App\Service\Interfaces;

use App\Dto\Report\ReportByDateDto;
use App\Entity\Report;
use App\Entity\ReportByDate;

/**
 * Interface ReportManagerInterface
 */
interface ReportManagerInterface
{
    /**
     * @param string $name
     * @param string $filter
     *
     * @return Report
     */
    public function createByFilter(string $name, string $filter): Report;
    
    /**
     * @param int $id
     *
     * @return Report
     */
    public function update(int $id): Report;
    
    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;
    
    /**
     * @param ReportByDateDto $reportByDateDto
     *
     * @return ReportByDate
     */
    public function createReportByDate(ReportByDateDto $reportByDateDto): ReportByDate;
    
    public function formingCommonReport(Report $report): ReportByDate;
    
    public function formingReportByUser(Report $report): void;
    
    public function formingReportByPriority(Report $report, array $priority = []): void;
}
