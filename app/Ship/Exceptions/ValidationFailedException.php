<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ValidationFailedException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_UNPROCESSABLE_ENTITY;

    /**
     * @var string
     */
    protected $message = 'Invalid Input.';
}
