<?php

declare(strict_types=1);

namespace App\Ship\Tests\Unit\Parents\Policies;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Policies\Policy;

class FakeUserPolicy extends Policy
{
    public function access(User $user): bool
    {
        return false;
    }
}
