<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit\Providers;

use App\Containers\AppSection\User\Providers\MainServiceProvider;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(MainServiceProvider::class)]
final class MainServiceProviderTest extends UnitTestCase
{
    private MainServiceProvider $provider;

    public function testProviderHasCorrectProviders(): void
    {
        self::assertSame([], $this->provider->serviceProviders);
    }

    public function testProviderHasCorrectAliases(): void
    {
        self::assertSame([], $this->provider->aliases);
    }

    public function testProviderSetsDefaultPasswordRules(): void
    {
        self::assertEquals(Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols(), Password::defaults());
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = app(MainServiceProvider::class, ['app' => app()]);
    }
}
