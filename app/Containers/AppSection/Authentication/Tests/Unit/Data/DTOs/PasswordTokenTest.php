<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Data\DTOs;

use App\Containers\AppSection\Authentication\Data\DTOs\PasswordToken;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\Values\RefreshToken;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(PasswordToken::class)]
final class PasswordTokenTest extends UnitTestCase
{
    public function testCanBeInstantiated(): void
    {
        $expiredIn = fake()->numberBetween();
        $accessToken = fake()->sha256();
        $refreshToken = fake()->sha256();
        $passwordToken = new PasswordToken(
            'Bearer',
            $expiredIn,
            $accessToken,
            RefreshToken::create($refreshToken),
        );

        $this->assertSame('Bearer', $passwordToken->tokenType);
        $this->assertSame($expiredIn, $passwordToken->expiresIn);
        $this->assertSame($accessToken, $passwordToken->accessToken);
        $this->assertSame($refreshToken, $passwordToken->refreshToken->value());
    }
}
