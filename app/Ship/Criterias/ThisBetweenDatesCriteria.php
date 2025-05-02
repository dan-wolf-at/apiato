<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class ThisBetweenDatesCriteria extends ParentCriteria
{
    public function __construct(
        private readonly string $field,
        private readonly Carbon $start,
        private readonly Carbon $end,
    ) {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->whereBetween($this->field, [$this->start->toDateString(), $this->end->toDateString()]);
    }
}
