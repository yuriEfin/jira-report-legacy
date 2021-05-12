<?php

namespace App\Entity\Embedded;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Type
 *
 * @ORM\Embeddable
 */
class Type
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_bug = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private int $count_feature = 0;
    
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
     * @return Type
     */
    public function setCountBug(int $count_bug): Type
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
     * @return Type
     */
    public function setCountFeature(int $count_feature): Type
    {
        $this->count_feature = $count_feature;
        
        return $this;
    }
}