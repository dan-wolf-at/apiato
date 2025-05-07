<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class OrderBySeveralFieldsCriteria extends ParentCriteria
{
    public function __construct(
        private readonly string $field,
        private readonly array $values,
    ) {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        $placeholders = implode(', ', array_fill(0, \count($this->values), '?'));

        return $model->orderByRaw(sprintf('FIELD(%s, %s)', $this->field, $placeholders), $placeholders);
    }
}
