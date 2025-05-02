<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DeleteResourceFailedException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_EXPECTATION_FAILED;

    /**
     * @var string
     */
    protected $message = 'Failed to delete Resource.';
}
