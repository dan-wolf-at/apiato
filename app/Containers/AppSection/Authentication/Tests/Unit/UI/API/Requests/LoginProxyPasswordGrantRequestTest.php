<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LoginProxyPasswordGrantRequest::class)]
final class LoginProxyPasswordGrantRequestTest extends UnitTestCase
{
    private LoginProxyPasswordGrantRequest $request;

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
        self::assertEquals(LoginFieldParser::mergeValidationRules(['password' => 'required']), $this->request->rules());
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $loginProxyPasswordGrantRequest = LoginProxyPasswordGrantRequest::injectData([], $this->getTestingUserWithoutAccess());

        self::assertTrue($loginProxyPasswordGrantRequest->authorize());
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new LoginProxyPasswordGrantRequest();
    }
}
