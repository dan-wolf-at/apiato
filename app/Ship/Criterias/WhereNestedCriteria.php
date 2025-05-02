<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

final class WhereNestedCriteria extends Criteria
{
    public function __construct(private readonly Closure $nested)
    {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        return $model->where($this->nested);
    }
}
