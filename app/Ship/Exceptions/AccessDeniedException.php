<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_FORBIDDEN;

    /**
     * @var string
     */
    protected $message = 'This action is unauthorized.';
}
