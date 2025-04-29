<?php

declare(strict_types=1);

namespace App\Ship\Tests\Unit\Parents\Policies;

use App\Ship\Parents\Providers\MainServiceProvider;

class FakeServiceProvider extends MainServiceProvider
{
    protected array $policies = [
        FakeUser::class => FakeUserPolicy::class,
    ];
}
