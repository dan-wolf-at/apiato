<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\WEB\Requests;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LoginRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LoginRequest::class)]
final class LoginRequestTest extends UnitTestCase
{
    private LoginRequest $request;

    public function testAccess(): void
    {
        self::assertSame([
            'permissions' => null,
            'roles'       => null,
        ], $this->request->getAccessArray());
    }

    public function testDecode(): void
    {
        self::assertSame([], $this->request->getDecodeArray());
    }

    public function testUrlParametersArray(): void
    {
        self::assertSame([], $this->request->getUrlParametersArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        self::assertSame(LoginFieldParser::mergeValidationRules([
            'password' => 'required',
            'remember' => 'boolean',
        ]), $rules);
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $loginRequest = LoginRequest::injectData([], $this->getTestingUserWithoutAccess());

        self::assertTrue($loginRequest->authorize());
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LoginRequest();
    }
}
