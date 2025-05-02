<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class NotImplementedException extends Exception
{
    /**
     * @var int
     */
    protected $code = Response::HTTP_NOT_IMPLEMENTED;

    /**
     * @var string
     */
    protected $message = 'This method is not yet implemented.';
}
