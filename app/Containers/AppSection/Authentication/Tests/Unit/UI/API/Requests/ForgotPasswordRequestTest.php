<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\ForgotPasswordRequest;
use Illuminate\Validation\Rule;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ForgotPasswordRequest::class)]
final class ForgotPasswordRequestTest extends UnitTestCase
{
    private ForgotPasswordRequest $request;

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
        self::assertEquals([
            'email'    => 'required|email',
            'reseturl' => [
                'required',
                Rule::in(config('appSection-authentication.allowed-reset-password-urls')),
            ],
        ], $this->request->rules());
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $forgotPasswordRequest = ForgotPasswordRequest::injectData([], $this->getTestingUserWithoutAccess());

        self::assertTrue($forgotPasswordRequest->authorize());
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ForgotPasswordRequest();
    }
}
