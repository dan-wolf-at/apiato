<?php

declare(strict_types=1);

namespace App\Ship\Criterias;

use App\Ship\Parents\Criterias\Criteria as ParentCriteria;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\RepositoryInterface as PrettusRepositoryInterface;

class SelectTableCriteria extends ParentCriteria
{
    public function __construct(private readonly ?array $fields = null)
    {
    }

    /**
     * @param Builder $model
     */
    public function apply($model, PrettusRepositoryInterface $repository): Builder
    {
        $fields = $this->fields ?? ['*'];

        return $model->select($fields);
    }
}
