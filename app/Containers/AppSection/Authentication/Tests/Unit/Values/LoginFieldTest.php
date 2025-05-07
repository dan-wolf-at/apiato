<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Values;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\Values\LoginField;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LoginField::class)]
final class LoginFieldTest extends UnitTestCase
{
    public function testCanCreateValue(): void
    {
        $loginField = new LoginField('email', ['required|email']);

        self::assertSame('email', $loginField->name());
        self::assertSame(['required|email'], $loginField->rules());
        self::assertSame('email', (string) $loginField);
        self::assertSame(['email' => ['required|email']], $loginField->toArray());
    }
}
