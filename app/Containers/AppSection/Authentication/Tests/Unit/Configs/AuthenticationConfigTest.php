<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Configs;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class AuthenticationConfigTest extends UnitTestCase
{
    public function testConfigHasCorrectValues(): void
    {
        self::assertIsArray(config('appSection-authentication'));
        self::assertArrayHasKey('require_email_verification', config('appSection-authentication'));
        self::assertFalse(config('appSection-authentication.require_email_verification'));
        self::assertArrayHasKey('email_verification_link_expiration_time_in_minute', config('appSection-authentication'));
        self::assertEquals(30, config('appSection-authentication.email_verification_link_expiration_time_in_minute'));
        self::assertArrayHasKey('clients', config('appSection-authentication'));
        self::assertArrayHasKey('web', config('appSection-authentication.clients'));
        self::assertArrayHasKey('id', config('appSection-authentication.clients.web'));
        self::assertArrayHasKey('secret', config('appSection-authentication.clients.web'));
        self::assertArrayHasKey('mobile', config('appSection-authentication.clients'));
        self::assertArrayHasKey('id', config('appSection-authentication.clients.mobile'));
        self::assertArrayHasKey('secret', config('appSection-authentication.clients.mobile'));
        self::assertArrayHasKey('login', config('appSection-authentication'));
        self::assertArrayHasKey('fields', config('appSection-authentication.login'));
        self::assertArrayHasKey('email', config('appSection-authentication.login.fields'));
        self::assertSame(['email'], config('appSection-authentication.login.fields.email'));
        self::assertArrayHasKey('prefix', config('appSection-authentication.login'));
        self::assertEmpty(config('appSection-authentication.login.prefix'));
        self::assertArrayHasKey('allowed-reset-password-urls', config('appSection-authentication'));
        self::assertSame([
            env('APP_URL', 'http://api.apiato.test/v1') . '/password/reset',
        ], config('appSection-authentication.allowed-reset-password-urls'));
        self::assertArrayHasKey('allowed-verify-email-urls', config('appSection-authentication'));
        self::assertSame([
            env('APP_URL', 'http://api.apiato.test/v1') . '/email/verify',
        ], config('appSection-authentication.allowed-verify-email-urls'));
    }
}
