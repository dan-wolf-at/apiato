<?php

declare(strict_types=1);

namespace App\Ship\Criteria;

use App\Ship\Parents\Criteria\Criteria as ParentCriteria;
use Carbon\CarbonImmutable;

class ThisBetweenDatesCriteria extends ParentCriteria
{
    public function __construct(
        private readonly string $field,
        private readonly CarbonImmutable $start,
        private readonly CarbonImmutable $end,
    ) {
    }

    public function apply($model, $repository)
    {
        return $model->whereBetween($this->field, [$this->start->toDateString(), $this->end->toDateString()]);
    }
}
