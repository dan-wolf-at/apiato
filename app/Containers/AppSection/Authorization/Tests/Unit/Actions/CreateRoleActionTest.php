<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tests\Unit\Actions;

use App\Containers\AppSection\Authorization\Actions\CreateRoleAction;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Ship\Enums\AuthGuard;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CreateRoleAction::class)]
final class CreateRoleActionTest extends UnitTestCase
{
    public function testCanCreateRole(): void
    {
        $createRoleRequest = CreateRoleRequest::injectData([
            'name'         => 'test-permission',
            'description'  => 'test-permission-description',
            'display_name' => 'test-permission-display-name',
        ]);
        $action = app(CreateRoleAction::class);

        $role = $action->run($createRoleRequest);

        self::assertSame($createRoleRequest->name, $role->name);
        self::assertSame($createRoleRequest->description, $role->description);
        self::assertSame($createRoleRequest->display_name, $role->display_name);
        self::assertSame(AuthGuard::API->value, $role->guard_name);
    }
}
