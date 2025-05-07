<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit\Policies;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Policies\UserPolicy;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserPolicy::class)]
final class UserPolicyTest extends UnitTestCase
{
    public function testCanDeleteUserOnlyIfAdmin(): void
    {
        $policy = app(UserPolicy::class);

        self::assertFalse($policy->delete());
    }

    public function testCanShowUserOnlyIfAdmin(): void
    {
        $policy = app(UserPolicy::class);

        self::assertFalse($policy->show());
    }

    public function testCanIndexUsersOnlyIfAdmin(): void
    {
        $policy = app(UserPolicy::class);

        self::assertFalse($policy->index());
    }

    public function testCanUpdateUserAsOwner(): void
    {
        $policy = app(UserPolicy::class);
        $model = UserFactory::new()->createOne();

        self::assertTrue($policy->update($model, $model->id));
    }
}
