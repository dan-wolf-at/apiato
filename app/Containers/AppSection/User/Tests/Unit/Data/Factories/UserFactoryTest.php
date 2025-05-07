<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit\Data\Factories;

use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Containers\AppSection\User\Enums\Gender;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserFactory::class)]
final class UserFactoryTest extends UnitTestCase
{
    public function testCanCreateUser(): void
    {
        $model = UserFactory::new()->createOne();

        self::assertInstanceOf(User::class, $model);
    }

    public function testCanCreateAdminUser(): void
    {
        $model = UserFactory::new()->admin()->createOne();

        self::assertTrue($model->hasRole(config('appSection-authorization.admin_role')));
    }

    public function testCanCreateUnverifiedUser(): void
    {
        $model = UserFactory::new()->unverified()->createOne();

        self::assertNull($model->email_verified_at);
    }

    public function testCanCreateVerifiedUser(): void
    {
        $model = UserFactory::new()->verified()->createOne();

        self::assertNotNull($model->email_verified_at);
    }

    public function testCanSetGender(): void
    {
        $model = UserFactory::new()->gender(Gender::MALE)->createOne();

        self::assertSame(Gender::MALE, $model->gender);
    }
}
