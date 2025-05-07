<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tests\Unit\UI\API\Controllers;

use App\Containers\AppSection\Authorization\Actions\DeleteRoleAction;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\UI\API\Controllers\DeleteRoleController;
use App\Containers\AppSection\Authorization\UI\API\Requests\DeleteRoleRequest;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\HttpFoundation\Response;

#[CoversClass(DeleteRoleController::class)]
final class DeleteRoleControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(DeleteRoleController::class);
        $deleteRoleRequest = DeleteRoleRequest::injectData();
        /** @var DeleteRoleAction|MockInterface $actionMock */
        $actionMock = $this->mock(DeleteRoleAction::class);
        $actionMock->expects()->run($deleteRoleRequest);

        $response = $controller($deleteRoleRequest, $actionMock);

        self::assertSame(Response::HTTP_NO_CONTENT, $response->getStatusCode(), $response->getContent());
    }
}
