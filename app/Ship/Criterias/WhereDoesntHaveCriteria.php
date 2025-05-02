<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

final class WhereDoesntHaveCriteria extends Criteria
{
    public function __construct(
        private readonly string $relation,
        private readonly string $relationColumn,
        private readonly string $condition,
        private readonly mixed $value,
    ) {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        return $model->whereDoesntHave($this->relation, function (Builder $query): void {
            $query->where($this->relationColumn, $this->condition, $this->value);
        });
    }
}
