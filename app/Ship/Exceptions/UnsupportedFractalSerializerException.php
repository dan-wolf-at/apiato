<?php

declare(strict_types=1);

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UnsupportedFractalSerializerException extends Exception
{
    /**
     * @var int
     */
    protected $code    = Response::HTTP_INTERNAL_SERVER_ERROR;

    /**
     * @var string
     */
    protected $message = 'Unsupported Fractal Serializer!';
}
