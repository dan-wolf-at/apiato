<?php

declare(strict_types=1);

namespace App\Ship\Middlewares;

use Apiato\Core\Middlewares\Http\Authenticate as CoreMiddleware;
use App\Ship\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class Authenticate extends CoreMiddleware
{
    #[\Override]
    protected function redirectTo(Request $request): null|string
    {
        if ($request->expectsJson()) {
            return null;
        }

        return route(RouteServiceProvider::LOGIN);
    }
}
