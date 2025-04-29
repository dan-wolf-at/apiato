<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tests\Unit\Traits;

use App\Containers\AppSection\Authorization\Traits\AuthorizationRepositoryTrait;
use App\Ship\Tests\Fakes\TestUser;
use App\Ship\Tests\Fakes\TestUserRepository;

class TraitTestRepository extends TestUserRepository
{
    use AuthorizationRepositoryTrait;

    #[\Override]
    public function model(): string
    {
        return TestUser::class;
    }
}
