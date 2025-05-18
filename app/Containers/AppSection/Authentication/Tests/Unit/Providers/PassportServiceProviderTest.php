<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Providers;

use App\Containers\AppSection\Authentication\Providers\PassportServiceProvider;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PassportServiceProvider::class)]
final class PassportServiceProviderTest extends UnitTestCase
{
    public function testCanConfigurePassport(): void
    {
        self::assertSame(59, Passport::$tokensExpireIn->i);
        self::assertSame(59, Passport::$refreshTokensExpireIn->i);
    }

    public function testRegistersPassportApiRoutes(): void
    {
        $registeredRoutes = Route::getRoutes();
        $registeredRoutes->refreshNameLookups();

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

        $apiPrefix = $this->removeLeadingSlashes(apiato()->routing()->getApiPrefix());
        $oAuthPrefix = $apiPrefix . 'v1/oauth';
        foreach ($passportRouteNames as $passportRouteName) {
            self::assertInstanceOf(\Illuminate\Routing\Route::class, $registeredRoutes->getByName($passportRouteName));
            $this->assertSamePrefix($oAuthPrefix, $registeredRoutes->getByName($passportRouteName)->getPrefix());
        }
    }

    public function testDoesntRegisterPassportWebRoutes(): void
    {
        $registeredRoutes = Route::getRoutes();
        $registeredRoutes->refreshNameLookups();

        $passportRouteNames = [
            'passport.authorizations.authorize',
            'passport.authorizations.approve',
            'passport.authorizations.deny',
        ];

        foreach ($passportRouteNames as $passportRouteName) {
            self::assertNotInstanceOf(\Illuminate\Routing\Route::class, $registeredRoutes->getByName($passportRouteName));
        }
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
