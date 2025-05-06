<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Providers;

use App\Ship\Parents\Providers\AuthServiceProvider as ParentAuthServiceProvider;
use Carbon\Carbon;
use Illuminate\Contracts\Support\DeferrableProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ParentAuthServiceProvider implements DeferrableProvider
{
    protected $policies = [];

    #[\Override]
    public function boot(): void
    {
        parent::boot();

        $this->configPassport();
    }

    #[\Override]
    public function register(): void
    {
        parent::register();

        Passport::ignoreRoutes();
    }

    private function configPassport(): void
    {
        if (config('apiato.api.enabled-implicit-grant')) {
            Passport::enableImplicitGrant();
        }

        Passport::$clientUuids = true;
        Passport::$registersJsonApiRoutes = true;
        Passport::enablePasswordGrant();

        $tokensExpireIn = Carbon::now()->addMinutes((int)config('apiato.api.expires-in'));
        $refreshTokensExpireIn = Carbon::now()->addMinutes((int)config('apiato.api.refresh-expires-in'));

        Passport::tokensExpireIn($tokensExpireIn);
        Passport::refreshTokensExpireIn($refreshTokensExpireIn);
    }
}
