<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Repositories\Concerns;

use App\Containers\AppSection\Authorization\Data\Criteria\WhereGuardCriteria;

trait InteractsWithGuard
{
    public function whereGuard(null|string $guard): static
    {
        if ($guard !== null) {
            $this->pushCriteriaWith(WhereGuardCriteria::class, ['guard' => $guard]);
        }

        return $this;
    }
}
