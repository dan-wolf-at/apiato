<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Requests;

use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\ListRolesRequest;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ListRolesRequest::class)]
final class ListRolesRequestTest extends UnitTestCase
{
    private ListRolesRequest $request;

    public function testAccess(): void
    {
        self::assertSame([
            'permissions' => 'manage-roles',
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

        self::assertSame([], $rules);
    }

    public function testAuthorizeMethodGateCall(): void
    {
        $userModel = $this->getTestingUser(access: ['permissions' => 'manage-roles']);
        $listRolesRequest = ListRolesRequest::injectData([], $userModel);

        self::assertTrue($listRolesRequest->authorize());
    }

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new ListRolesRequest();
    }
}
