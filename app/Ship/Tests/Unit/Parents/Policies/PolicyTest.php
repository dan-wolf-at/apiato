<?php

declare(strict_types=1);

namespace App\Ship\Tests\Unit\Parents\Policies;

use App\Ship\Parents\Policies\Policy;
use App\Ship\Tests\ShipTestCase;
use Illuminate\Contracts\Auth\Access\Gate;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Policy::class)]
final class PolicyTest extends ShipTestCase
{
    public function testAdminCanBypassAllAuthorizations(): void
    {
        $this->getTestingUser(createUserAsAdmin: true);

        $fakeRequest = FakeRequest::injectData([], $this->testingUser);

        self::assertTrue($fakeRequest->authorize(app(Gate::class)));
    }

    public function testNonAdminCannotBypassAllAuthorizations(): void
    {
        $this->getTestingUser();

        $fakeRequest = FakeRequest::injectData([], $this->testingUser);

        self::assertFalse($fakeRequest->authorize(app(Gate::class)));
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(FakeServiceProvider::class);
    }
}
