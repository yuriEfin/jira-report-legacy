<?php

namespace App\Dto\Report;

use App\Entity\Report;
use DateTimeInterface;
use DateTime;

/**
 * Class ReportByDateDto
 */
class ReportByDateDto
{
	private ?int $id;
	
	private Report $report;
	
	private ?string $date;

	private int $count_all = 0;
 
	// statuses
    private int $count_todo = 0;
    
    private int $count_progress = 0;
    
    private int $count_review = 0;
    
    private int $count_reopened = 0;
    
    private int $count_tests = 0;
    
    private int $count_in_tests = 0;
    
    private int $count_pause = 0;
    
    // priority
    private int $count_blocker = 0;
    
    private int $count_highest = 0;
    
    private int $count_high = 0;
    
    private int $count_medium = 0;
    
    private int $count_low = 0;
    
    private int $count_lowest = 0;
    
    // types
    private int $count_bug = 0;
    private int $count_feature = 0;
	
    // common data
	private ?array $data_by_user = [];
	
	private ?DateTimeInterface $created_at;
	
	/**
	 * ReportByDate constructor.
	 */
	public function __construct()
	{
		$this->created_at = new DateTime();
	}
    
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @param int|null $id
     *
     * @return ReportByDateDto
     */
    public function setId(?int $id): ReportByDateDto
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * @return Report
     */
    public function getReport(): Report
    {
        return $this->report;
    }
    
    /**
     * @param Report $report
     *
     * @return ReportByDateDto
     */
    public function setReport(Report $report): ReportByDateDto
    {
        $this->report = $report;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }
    
    /**
     * @param string|null $date
     *
     * @return ReportByDateDto
     */
    public function setDate(?string $date): ReportByDateDto
    {
        $this->date = $date;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountAll(): int
    {
        return $this->count_all;
    }
    
    /**
     * @param int $count_all
     *
     * @return ReportByDateDto
     */
    public function setCountAll(int $count_all): ReportByDateDto
    {
        $this->count_all = $count_all;
        
        return $this;
    }
    
    // statuses
    
    /**
     * @return int
     */
    public function getCountTodo(): int
    {
        return $this->count_todo;
    }
    
    /**
     * @param int $count_todo
     *
     * @return ReportByDateDto
     */
    public function setCountTodo(int $count_todo): ReportByDateDto
    {
        $this->count_todo = $count_todo;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountProgress(): int
    {
        return $this->count_progress;
    }
    
    /**
     * @param int $count_progress
     *
     * @return ReportByDateDto
     */
    public function setCountProgress(int $count_progress): ReportByDateDto
    {
        $this->count_progress = $count_progress;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountReview(): int
    {
        return $this->count_review;
    }
    
    /**
     * @param int $count_review
     *
     * @return ReportByDateDto
     */
    public function setCountReview(int $count_review): ReportByDateDto
    {
        $this->count_review = $count_review;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountReopened(): int
    {
        return $this->count_reopened;
    }
    
    /**
     * @param int $count_reopened
     *
     * @return ReportByDateDto
     */
    public function setCountReopened(int $count_reopened): ReportByDateDto
    {
        $this->count_reopened = $count_reopened;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountTests(): int
    {
        return $this->count_tests;
    }
    
    /**
     * @param int $count_tests
     *
     * @return ReportByDateDto
     */
    public function setCountTests(int $count_tests): ReportByDateDto
    {
        $this->count_tests = $count_tests;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountInTests(): int
    {
        return $this->count_in_tests;
    }
    
    /**
     * @param int $count_in_tests
     *
     * @return ReportByDateDto
     */
    public function setCountInTests(int $count_in_tests): ReportByDateDto
    {
        $this->count_in_tests = $count_in_tests;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountPause(): int
    {
        return $this->count_pause;
    }
    
    /**
     * @param int $count_pause
     *
     * @return ReportByDateDto
     */
    public function setCountPause(int $count_pause): ReportByDateDto
    {
        $this->count_pause = $count_pause;
        
        return $this;
    }
    
    // priority
    
    /**
     * @return int
     */
    public function getCountBlocker(): int
    {
        return $this->count_blocker;
    }
    
    /**
     * @param int $count_blocker
     *
     * @return ReportByDateDto
     */
    public function setCountBlocker(int $count_blocker): ReportByDateDto
    {
        $this->count_blocker = $count_blocker;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountHighest(): int
    {
        return $this->count_highest;
    }
    
    /**
     * @param int $count_highest
     *
     * @return ReportByDateDto
     */
    public function setCountHighest(int $count_highest): ReportByDateDto
    {
        $this->count_highest = $count_highest;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountHigh(): int
    {
        return $this->count_high;
    }
    
    /**
     * @param int $count_high
     *
     * @return ReportByDateDto
     */
    public function setCountHigh(int $count_high): ReportByDateDto
    {
        $this->count_high = $count_high;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountMedium(): int
    {
        return $this->count_medium;
    }
    
    /**
     * @param int $count_medium
     *
     * @return ReportByDateDto
     */
    public function setCountMedium(int $count_medium): ReportByDateDto
    {
        $this->count_medium = $count_medium;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountLow(): int
    {
        return $this->count_low;
    }
    
    /**
     * @param int $count_low
     *
     * @return ReportByDateDto
     */
    public function setCountLow(int $count_low): ReportByDateDto
    {
        $this->count_low = $count_low;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountLowest(): int
    {
        return $this->count_lowest;
    }
    
    /**
     * @param int $count_lowest
     *
     * @return ReportByDateDto
     */
    public function setCountLowest(int $count_lowest): ReportByDateDto
    {
        $this->count_lowest = $count_lowest;
        
        return $this;
    }
    
    // types
    
    /**
     * @return int
     */
    public function getCountBug(): int
    {
        return $this->count_bug;
    }
    
    /**
     * @param int $count_bug
     *
     * @return ReportByDateDto
     */
    public function setCountBug(int $count_bug): ReportByDateDto
    {
        $this->count_bug = $count_bug;
        
        return $this;
    }
    
    /**
     * @return int
     */
    public function getCountFeature(): int
    {
        return $this->count_feature;
    }
    
    /**
     * @param int $count_feature
     *
     * @return ReportByDateDto
     */
    public function setCountFeature(int $count_feature): ReportByDateDto
    {
        $this->count_feature = $count_feature;
        
        return $this;
    }
    
    /**
     * @return array|null
     */
    public function getDataByUser(): ?array
    {
        return $this->data_by_user ?? [];
    }
    
    /**
     * @param array|null $data_by_user
     *
     * @return ReportByDateDto
     */
    public function setDataByUser(?array $data_by_user): ReportByDateDto
    {
        $this->data_by_user = $data_by_user ?? [];
        
        return $this;
    }
    
    /**
     * @return DateTime|DateTimeInterface|null
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    /**
     * @param DateTime|DateTimeInterface|null $created_at
     *
     * @return ReportByDateDto
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        
        return $this;
    }
}
