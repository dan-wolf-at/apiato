<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ThisUsersCriteria extends ParentCriteria
{
    /**
     * @param int|array<int> $userIds
     */
    public function __construct(
        private readonly array $userIds,
        private readonly ?string $table = null,
    ) {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        if ($this->userIds !== []) {
            $table = $this->table ?? $model->getModel()->getTable();

            return $model->whereIn($table . '.user_id', $this->userIds);
        }

        return $model;
    }
}
