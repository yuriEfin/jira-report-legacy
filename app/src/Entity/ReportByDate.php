<?php

namespace App\Entity;

use App\Entity\Embedded\Priority;
use App\Entity\Embedded\Statuses;
use App\Entity\Embedded\Type;
use App\Repository\ReportByDateRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=ReportByDateRepository::class)
 */
class ReportByDate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\ManyToOne (targetEntity="Report")
     */
    private Report $report;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $date;
    
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $count_all = 0;
    
    /**
     * @var Priority|null
     * @ORM\Embedded(class="App\Entity\Embedded\Priority")
     */
    private Priority $priority;
    
    /**
     * @var Type|null
     * @ORM\Embedded(class="App\Entity\Embedded\Type")
     */
    private Type $type;
    
    /**
     * @var Statuses|null
     * @ORM\Embedded(class="App\Entity\Embedded\Statuses")
     */
    private Statuses $statuses;
    
    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private array $data_by_user;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $created_at;
    
    /**
     * ReportByDate constructor.
     */
    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->date = (new DateTime())->format('Y-m-d');
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
     * @return ReportByDate
     */
    public function setReport(Report $report): ReportByDate
    {
        $this->report = $report;
        
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
     * @return ReportByDate
     */
    public function setCountAll(int $count_all): ReportByDate
    {
        $this->count_all = $count_all;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getDataByUser(): array
    {
        return $this->data_by_user;
    }
    
    /**
     * @param array $data_by_user
     *
     * @return ReportByDate
     */
    public function setDataByUser(array $data_by_user): ReportByDate
    {
        $this->data_by_user = $data_by_user;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }
    
    /**
     * @param string $date
     *
     * @return ReportByDate
     */
    public function setDate(string $date): ReportByDate
    {
        $this->date = $date;
        
        return $this;
    }
    
    /**
     * @return Priority
     */
    public function getPriority(): Priority
    {
        return $this->priority;
    }
    
    /**
     * @param Priority $priority
     *
     * @return ReportByDate
     */
    public function setPriority(Priority $priority): ReportByDate
    {
        $this->priority = $priority;
        
        return $this;
    }
    
    /**
     * @return Statuses
     */
    public function getStatuses(): Statuses
    {
        return $this->statuses;
    }
    
    /**
     * @param Statuses $statuses
     *
     * @return ReportByDate
     */
    public function setStatuses(Statuses $statuses): ReportByDate
    {
        $this->statuses = $statuses;
        
        return $this;
    }
    
    /**
     * @return Type|null
     */
    public function getType(): ?Type
    {
        return $this->type;
    }
    
    /**
     * @param Type|null $type
     *
     * @return ReportByDate
     */
    public function setType(?Type $type): ReportByDate
    {
        $this->type = $type;
        
        return $this;
    }
    
    /**
     * @return DateTime|DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    
    /**
     * @param DateTime|DateTimeInterface $created_at
     *
     * @return ReportByDate
     */
    public function setCreatedAt(DateTimeInterface $created_at): ReportByDate
    {
        $this->created_at = $created_at;
        
        return $this;
    }
}
