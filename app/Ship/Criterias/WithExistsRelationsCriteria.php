<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class WithExistsRelationsCriteria extends ParentCriteria
{
    public function __construct(private readonly string|array $relations)
    {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->withExists($this->relations);
    }
}
