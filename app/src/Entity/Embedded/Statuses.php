<?php

namespace App\Entity\Embedded;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Statuses
 *
 * @ORM\Embeddable
 */
class Statuses
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_todo = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_progress = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_review = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_reopened = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $count_tests = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_in_tests = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_pause = 0;
    
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
     * @return Statuses
     */
    public function setCountTodo(int $count_todo): Statuses
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
     * @return Statuses
     */
    public function setCountProgress(int $count_progress): Statuses
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
     * @return Statuses
     */
    public function setCountReview(int $count_review): Statuses
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
     * @return Statuses
     */
    public function setCountReopened(int $count_reopened): Statuses
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
     * @return Statuses
     */
    public function setCountTests(int $count_tests): Statuses
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
     * @return Statuses
     */
    public function setCountInTests(int $count_in_tests): Statuses
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
     * @return Statuses
     */
    public function setCountPause(int $count_pause): Statuses
    {
        $this->count_pause = $count_pause;
        
        return $this;
    }
}
