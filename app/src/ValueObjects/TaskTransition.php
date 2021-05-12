<?php

namespace App\ValueObjects;

/**
 * Class TaskTransition
 */
class TaskTransition
{
    public const PAUSE = 'PAUSE';
    public const CLOSE = 'CLOSE';
    public const IN_PROGRESS = 'IN PROGRESS';
    public const CREATE = 'CREATE';
    public const REOPEN = 'REOPEN';
    public const CANCEL = 'CANCEL';
    public const TEST = 'TEST';
    public const IN_TEST = 'IN TEST';
    public const REVIEW = 'IN REVIEW';
}