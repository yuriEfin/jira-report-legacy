<?php

namespace App\Dto\Issue;

use App\ValueObjects\TaskTransition;

/**
 * Class IssueDto
 */
class IssueDto
{
    /**
     * @var string|null
     */
    private $issueKey;
    /**
     * @var array|null
     */
    private $fixVersion = [];
    /**
     * @var array|null
     */
    private $affectedVersion = [];
    /**
     * @var string|null
     */
    private $priority;
    /**
     * @var array|null
     */
    private $label = [];
    /**
     * @var string|null
     */
    private $assigneeName;
    /**
     * @var string|null
     */
    private $status;
    /**
     * @var array
     */
    private $component = [];
    /**
     * @var string|null
     */
    private $summary = '';
    /**
     * @var string|null
     */
    private $comment = '';
    /**
     * @var string
     */
    private $issueSearchPrefix = '';
    
    /**
     * @return string|null
     */
    public function getIssueKey(): ?string
    {
        return $this->issueKey;
    }
    
    /**
     * @param string|null $issueKey
     *
     * @return IssueDto
     */
    public function setIssueKey(?string $issueKey): IssueDto
    {
        $this->issueKey = $issueKey;
        
        return $this;
    }
    
    /**
     * @return array|null
     */
    public function getFixVersion(): ?array
    {
        return $this->fixVersion;
    }
    
    /**
     * @param array|null $fixVersion
     *
     * @return IssueDto
     */
    public function setFixVersion(?string $fixVersion): IssueDto
    {
        $this->fixVersion = explode(',', $fixVersion);
        
        return $this;
    }
    
    /**
     * @return array|null
     */
    public function getAffectedVersion(): ?array
    {
        return $this->affectedVersion;
    }
    
    /**
     * @param array|null $affectedVersion
     *
     * @return IssueDto
     */
    public function setAffectedVersion(?string $affectedVersion): IssueDto
    {
        $this->affectedVersion = explode(',', $affectedVersion);
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }
    
    /**
     * @param string|null $priority
     *
     * @return IssueDto
     */
    public function setPriority(?string $priority): IssueDto
    {
        $this->priority = $priority;
        
        return $this;
    }
    
    /**
     * @return array|null
     */
    public function getLabel(): ?array
    {
        return $this->label;
    }
    
    /**
     * @param array|null $label
     *
     * @return IssueDto
     */
    public function setLabel(?string $label): IssueDto
    {
        $this->label = explode(',', $label);
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getAssigneeName(): ?string
    {
        return $this->assigneeName;
    }
    
    /**
     * @param string|null $assigneeName
     *
     * @return IssueDto
     */
    public function setAssigneeName(?string $assigneeName): IssueDto
    {
        $this->assigneeName = $assigneeName;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }
    
    /**
     * @param string|null $status
     *
     * @return IssueDto
     */
    public function setStatus(?string $status): IssueDto
    {
        $this->status = $status;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function getComponent(): array
    {
        return $this->component;
    }
    
    /**
     * @param array|null $component
     *
     * @return IssueDto
     */
    public function setComponent(?array $component): IssueDto
    {
        $this->component = $component ?? [];
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getSummary(): ?string
    {
        return $this->summary;
    }
    
    /**
     * @param string|null $summary
     *
     * @return IssueDto
     */
    public function setSummary(?string $summary): IssueDto
    {
        $this->summary = $summary;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }
    
    /**
     * @param string|null $comment
     *
     * @return IssueDto
     */
    public function setComment(?string $comment): IssueDto
    {
        $this->comment = $comment;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getIssueSearchPrefix(): string
    {
        return $this->issueSearchPrefix;
    }
    
    /**
     * @param string $issueSearchPrefix
     *
     * @return IssueDto
     */
    public function setIssueSearchPrefix(string $issueSearchPrefix): IssueDto
    {
        $this->issueSearchPrefix = $issueSearchPrefix;
        
        return $this;
    }
}
