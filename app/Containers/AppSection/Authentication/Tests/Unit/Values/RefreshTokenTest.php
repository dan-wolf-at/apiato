<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Values;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\Values\RefreshToken;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RefreshToken::class)]
final class RefreshTokenTest extends UnitTestCase
{
    public function testCanCreateCookieProperly(): void
    {
        $refreshToken = RefreshToken::create(fake()->sha256());

        $cookie = $refreshToken->asCookie();

        self::assertSame(RefreshToken::cookieName(), $cookie->getName());
        self::assertSame($refreshToken->value(), $cookie->getValue());
        self::assertSame((int) config('appSection-authentication.refresh-tokens-expire-in'), $cookie->getExpiresTime());
        self::assertSame('/', $cookie->getPath());
        self::assertNull($cookie->getDomain());
        self::assertEquals(config('session.secure'), $cookie->isSecure());
        self::assertEquals(config('session.http_only'), $cookie->isHttpOnly());
    }
}
