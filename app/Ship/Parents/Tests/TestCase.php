<?php

declare(strict_types=1);

namespace App\Ship\Parents\Tests;

use Apiato\Core\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;
use App\Ship\Enums\AuthGuard;
use Illuminate\Contracts\Console\Kernel as ApiatoConsoleKernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class TestCase extends AbstractTestCase
{
    use WithFaker;

    public static function authGuardDataProvider(): array
    {
        return array_map(static fn (AuthGuard $guard): array => [$guard->value], AuthGuard::cases());
    }

    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../../../../bootstrap/app.php';

        $app->make(ApiatoConsoleKernel::class)->bootstrap();

        return $app;
    }
}
