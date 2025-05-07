<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Tests\Unit\Traits;

use App\Containers\AppSection\Authorization\Data\Criterias\WhereGuardCriteria;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Containers\AppSection\Authorization\Traits\AuthorizationRepositoryTrait;
use App\Ship\Enums\AuthGuard;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(AuthorizationRepositoryTrait::class)]
final class AuthorizationRepositoryTraitTest extends UnitTestCase
{
    public function testItPushesCriteriaWhenGuardIsNotNull(): void
    {
        $traitTestRepository = new TraitTestRepository(app());
        $guard = AuthGuard::WEB->value;

        $traitTestRepository->whereGuard($guard);

        self::assertSame($guard, $this->getInaccessiblePropertyValue($traitTestRepository->getCriteria()->first(), 'guard'));
        self::assertContains(WhereGuardCriteria::class, $traitTestRepository->getCriteria()->map(static fn ($criteria): string|false => $criteria::class));
    }

    public function testItDoesNotPushCriteriaWhenGuardIsNull(): void
    {
        $traitTestRepository = new TraitTestRepository(app());
        $guard = null;

        $traitTestRepository->whereGuard($guard);

        self::assertNotContains(WhereGuardCriteria::class, $traitTestRepository->getCriteria()->map(static fn ($criteria): string|false => $criteria::class));
    }
}
