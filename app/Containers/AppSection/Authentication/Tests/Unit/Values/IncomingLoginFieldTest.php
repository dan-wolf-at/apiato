<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Values;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\Values\IncomingLoginField;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(IncomingLoginField::class)]
final class IncomingLoginFieldTest extends UnitTestCase
{
    public function testCanCreateValue(): void
    {
        $incomingLoginField = new IncomingLoginField('email', 'gandalf@the.grey');

        self::assertSame('email', $incomingLoginField->name);
        self::assertSame('gandalf@the.grey', $incomingLoginField->value);
    }
}
