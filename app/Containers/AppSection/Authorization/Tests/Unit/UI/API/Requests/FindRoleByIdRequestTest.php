<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Data\Factories\RoleFactory;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\FindRoleByIdRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(FindRoleByIdRequest::class)]
final class FindRoleByIdRequestTest extends UnitTestCase
{
    private FindRoleByIdRequest $request;

    public function testAccess(): void
    {
        self::assertSame([
            'permissions' => 'manage-roles',
            'roles'       => null,
        ], $this->request->getAccessArray());
    }

    public function testDecode(): void
    {
        self::assertSame([
            'role_id',
        ], $this->request->getDecodeArray());
    }

    public function testUrlParametersArray(): void
    {
        self::assertSame([
            'role_id',
        ], $this->request->getUrlParametersArray());
    }

    public function testValidationRules(): void
    {
        $rules = $this->request->rules();

        self::assertSame([], $rules);
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $userModel = $this->getTestingUser(access: ['permissions' => 'manage-roles']);
        $findRoleByIdRequest = FindRoleByIdRequest::injectData([], $userModel)->withUrlParameters(['role_id' => RoleFactory::new()->createOne()->id]);

        self::assertTrue($findRoleByIdRequest->authorize());
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new FindRoleByIdRequest();
    }
}
