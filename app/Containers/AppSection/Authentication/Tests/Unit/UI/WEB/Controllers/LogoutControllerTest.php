<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\UI\WEB\Controllers;

use App\Containers\AppSection\Authentication\Actions\WebLogoutAction;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\HomePageController;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LogoutController;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LogoutRequest;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(LogoutController::class)]
final class LogoutControllerTest extends UnitTestCase
{
    public function testControllerCallsCorrectAction(): void
    {
        $controller = app(LogoutController::class);
        $logoutRequest = LogoutRequest::injectData();
        /** @var WebLogoutAction|MockInterface $mock */
        $mock = $this->mock(WebLogoutAction::class);
        $mock->expects()->run();

        $response = $controller($logoutRequest, $mock);

        self::assertTrue($response->isRedirect(action(HomePageController::class)));
    }
}
