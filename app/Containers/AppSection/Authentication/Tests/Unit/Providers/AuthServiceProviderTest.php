<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Providers;

use App\Containers\AppSection\Authentication\Providers\AuthServiceProvider;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AuthServiceProvider::class)]
final class AuthServiceProviderTest extends UnitTestCase
{
    private AuthServiceProvider $provider;

    public function testProviderHasCorrectFields(): void
    {
        self::assertTrue($this->provider->isDeferred());
        self::assertSame([], $this->provider->policies());
    }

    public function testCanConfigurePassport(): void
    {
        self::assertTrue(Passport::$implicitGrantEnabled);
        self::assertFalse(Passport::$clientUuids);
        self::assertTrue(Passport::$passwordGrantEnabled);

        self::assertEquals('PT59M', Passport::$tokensExpireIn->format('PT%iM'));
        self::assertEquals('PT59M', Passport::$refreshTokensExpireIn->format('PT%iM'));
    }

    public function testRegistersPassportApiRoutes(): void
    {
        $routeCollection = Route::getRoutes();
        $routeCollection->refreshNameLookups();

        $passportRouteNames = [
            'passport.token',
            'passport.tokens.index',
            'passport.tokens.destroy',

            'passport.token.refresh',

            'passport.clients.index',
            'passport.clients.store',
            'passport.clients.update',
            'passport.clients.destroy',

            'passport.scopes.index',
            'passport.personal.tokens.index',
            'passport.personal.tokens.store',
            'passport.personal.tokens.destroy',
        ];

        $apiPrefix = $this->removeLeadingSlashes(config('apiato.api.prefix'));
        $oAuthPrefix = $apiPrefix . 'v1/oauth';
        foreach ($passportRouteNames as $passportRouteName) {
            self::assertInstanceOf(\Illuminate\Routing\Route::class, $routeCollection->getByName($passportRouteName));
            $this->assertSamePrefix($oAuthPrefix, $routeCollection->getByName($passportRouteName)->getPrefix());
        }
    }

    public function testDoesntRegisterPassportWebRoutes(): void
    {
        $routeCollection = Route::getRoutes();
        $routeCollection->refreshNameLookups();

        $passportRouteNames = [
            'passport.authorizations.authorize',
            'passport.authorizations.approve',
            'passport.authorizations.deny',
        ];

        foreach ($passportRouteNames as $passportRouteName) {
            self::assertNotInstanceOf(\Illuminate\Routing\Route::class, $routeCollection->getByName($passportRouteName));
        }
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = app(AuthServiceProvider::class, ['app' => app()]);
    }

    private function removeLeadingSlashes(string $value): string
    {
        return ltrim($value, '/');
    }

    private function assertSamePrefix(string $prefix, string $endpoint): void
    {
        self::assertSame($prefix, $endpoint, 'The prefix of the route does not match the expected value.');
    }
}
