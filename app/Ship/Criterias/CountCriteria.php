<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class CountCriteria extends ParentCriteria
{
    public function __construct(private readonly string $field)
    {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): QueryBuilder
    {
        return DB::table($model->getModel()->getTable())->select($this->field, DB::raw('count(' . $this->field . ') as total_count'))->groupBy($this->field);
    }
}
