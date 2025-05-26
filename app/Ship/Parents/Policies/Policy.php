<?php

declare(strict_types=1);

namespace App\Ship\Parents\Policies;

use Apiato\Core\Policies\Policy as AbstractPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy extends AbstractPolicy
{
    use HandlesAuthorization;
}
