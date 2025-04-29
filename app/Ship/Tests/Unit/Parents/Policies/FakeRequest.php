<?php

declare(strict_types=1);

namespace App\Ship\Tests\Unit\Parents\Policies;

use App\Ship\Parents\Requests\Request;
use Illuminate\Contracts\Auth\Access\Gate;

class FakeRequest extends Request
{
    public function authorize(Gate $gate): bool
    {
        return $gate->allows('access', FakeUser::class);
    }
}
