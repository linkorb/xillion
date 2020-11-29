<?php

namespace Xillion\Core\Validator;

class ValidationIssue
{
    public const DEBUG = 1;
    public const INFO = 2;
    public const WARNING = 3;
    public const ERROR = 4;

    protected $level;
    protected $message;

    public function __construct(int $level, string $message)
    {
        $this->level = $level;
        $this->message = $message;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getLevelString(): string
    {
        switch ($this->level) {

        }
    }

    public function getMessage(): string
    {
        return $this->message;
    }


}
