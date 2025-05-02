<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Actions;

use App\Ship\Enums\AuthGuard;
use App\Ship\Parents\Actions\Action as ParentAction;
use Illuminate\Support\Facades\Auth;

class WebLogoutAction extends ParentAction
{
    public function run(): void
    {
        Auth::guard(AuthGuard::WEB->value)->logout();
    }
}
