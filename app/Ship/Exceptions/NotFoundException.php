<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_NOT_FOUND;

    /**
     * @var string
     */
    protected $message = 'The requested resource could not be found.';
}
