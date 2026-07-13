<?php

namespace App\Exceptions;

use Exception;

class EnrollmentException extends Exception
{
    protected string $errorCode = 'ENROLLMENT_ERROR';
    protected int $status = 422;
    protected string $defaultMessage = 'Enrollment error occurred.';

    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? $this->defaultMessage, $this->status);
    }

    public function errorCode(): string
    {
        return $this->errorCode;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function responsePayload(): array
    {
        return [
            'success' => false,
            'message' => $this->getMessage(),
            'error' => [
                'code' => $this->errorCode(),
                'status' => $this->status(),
            ],
        ];
    }
}
