<?php

namespace App\Entity\Embedded;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Priority
 *
 * @ORM\Embeddable
 */
class Priority
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_blocker = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_highest = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_high = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_medium = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_low = 0;
    
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_lowest = 0;
    
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
     * @return Priority
     */
    public function setCountBlocker(int $count_blocker): Priority
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
     * @return Priority
     */
    public function setCountHighest(int $count_highest): Priority
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
     * @return Priority
     */
    public function setCountHigh(int $count_high): Priority
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
     * @return Priority
     */
    public function setCountMedium(int $count_medium): Priority
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
     * @return Priority
     */
    public function setCountLow(int $count_low): Priority
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
     * @return Priority
     */
    public function setCountLowest(int $count_lowest): Priority
    {
        $this->count_lowest = $count_lowest;
        
        return $this;
    }
}
