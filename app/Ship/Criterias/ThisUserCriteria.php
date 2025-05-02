<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ThisUserCriteria extends ParentCriteria
{
    public function __construct(
        private readonly int $userId,
        private readonly ?string $table = null,
    ) {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        $table = $this->table ?? $model->getModel()->getTable();

        return $model->where($table . '.user_id', '=', $this->userId);
    }
}
