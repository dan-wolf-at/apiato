<?php

declare(strict_types=1);

namespace App\Ship\Parents\Providers;

use Apiato\Core\Abstracts\Providers\MiddlewareServiceProvider as AbstractMiddlewareServiceProvider;

abstract class MiddlewareServiceProvider extends AbstractMiddlewareServiceProvider
{
    /**
     * @var array<int, class-string|string>
     */
    protected array $middlewares = [];

    /**
     * @var array<string, array<int, class-string|string>>
     */
    protected array $middlewareGroups = [];

    /**
     * @var array<string, class-string|string>
     */
    protected array $middlewareAliases = [];

    /**
     * @var string[]
     */
    protected array $middlewarePriority = [];
}
