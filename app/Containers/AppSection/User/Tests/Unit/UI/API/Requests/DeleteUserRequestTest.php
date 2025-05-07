<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use App\Containers\AppSection\User\UI\API\Requests\DeleteUserRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(DeleteUserRequest::class)]
final class DeleteUserRequestTest extends UnitTestCase
{
    private DeleteUserRequest $request;

    public function testDecode(): void
    {
        self::assertSame([
            'user_id',
        ], $this->request->getDecodeArray());
    }

    public function testUrlParametersArray(): void
    {
        self::assertSame([
            'user_id',
        ], $this->request->getUrlParametersArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        self::assertSame([], $rules);
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $deleteUserRequest = DeleteUserRequest::injectData();
        $gateMock = $this->getGateMock('delete', [
            User::class,
        ]);

        self::assertTrue($deleteUserRequest->authorize($gateMock));
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new DeleteUserRequest();
    }
}
