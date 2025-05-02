<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface;

class ThisNotEqualThatCriteria extends Criteria
{
    public function __construct(
        private readonly string $field,
        private readonly mixed $value,
    ) {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, RepositoryInterface $repository): Builder
    {
        return $model->whereNot($this->field, $this->value);
    }
}
