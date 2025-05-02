<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class CreatedTodayCriteria extends ParentCriteria
{
    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        return $model->where('created_at', '>=', Carbon::today()->toIso8601String());
    }
}
