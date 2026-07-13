<?php

namespace App\Exceptions;

use App\Exceptions\EnrollmentException;

use Exception;

class UserAlreadyEnrolledException extends EnrollmentException
{
    protected string $errorCode = 'USER_ALREADY_ENROLLED';
    protected int $status = 400;
    protected string $defaultMessage = 'User is already enrolled in this course.';
}
