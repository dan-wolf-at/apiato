<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Values;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\Values\Token;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Token::class)]
final class TokenTest extends UnitTestCase
{
    public function testCanCreateValue(): void
    {
        $token = new Token(fake()->word(), fake()->numberBetween(), fake()->sha256(), fake()->sha256());

        self::assertSame('string', \gettype($token->tokenType));
        self::assertSame('integer', \gettype($token->expiresIn));
        self::assertSame('string', \gettype($token->accessToken));
        self::assertSame('string', \gettype($token->refreshToken));
    }

    public function testCanCreateFakeValue(): void
    {
        $token = Token::fake();

        self::assertSame('string', \gettype($token->tokenType));
        self::assertSame('integer', \gettype($token->expiresIn));
        self::assertSame('string', \gettype($token->accessToken));
        self::assertSame('string', \gettype($token->refreshToken));
    }
}
