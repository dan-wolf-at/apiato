<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class OrderByUpdateDateAscendingCriteria extends ParentCriteria
{
    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->orderBy('updated_at', 'asc');
    }
}
