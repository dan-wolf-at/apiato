<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class MinCriteria extends ParentCriteria
{
    public function __construct(
        private readonly string $field,
        private readonly string $asField,
        private readonly array $fieldsInSelect,
    ) {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->selectRaw(
            sprintf(
                'MIN(%s) AS %s %s',
                $this->field,
                $this->asField,
                $this->fieldsInSelect === [] ? '' : (',' . implode(',', $this->fieldsInSelect))
            )
        );
    }
}
