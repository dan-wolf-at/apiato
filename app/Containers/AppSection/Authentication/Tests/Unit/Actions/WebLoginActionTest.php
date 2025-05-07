<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\WebLoginAction;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\AppSection\User\Data\Factories\UserFactory;
use App\Ship\Enums\AuthGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(WebLoginAction::class)]
final class WebLoginActionTest extends UnitTestCase
{
    public static function allowedLoginDataProvider(): \Iterator
    {
        yield [
            [
                'email' => 'gandalf@the.grey',
            ],
            [
                'email',
            ],
        ];
        // Should fail because name is not allowed
        // [
        //     'loginFields' => [
        //         'name' => 'gandalf',
        //     ],
        //     'allowedFields' => [
        //         'email',
        //     ],
        // ],
        yield [
            [
                'email' => 'gandalf@the.grey',
                'name'  => 'gandalf',
            ],
            [
                'email',
            ],
        ];
        yield [
            [
                'name'  => 'gandalf',
                'email' => 'gandalf@the.grey',
            ],
            [
                'email',
            ],
        ];
        // Should fail because email is not allowed
        // [
        //     'loginFields' => [
        //         'email' => 'gandalf@the.grey',
        //     ],
        //     'allowedFields' => [
        //         'name',
        //     ],
        // ],
        yield [
            [
                'name' => 'gandalf',
            ],
            [
                'name',
            ],
        ];
        yield [
            [
                'email' => 'gandalf@the.grey',
                'name'  => 'gandalf',
            ],
            [
                'name',
            ],
        ];
        yield [
            [
                'name'  => 'gandalf',
                'email' => 'gandalf@the.grey',
            ],
            [
                'name',
            ],
        ];
        yield [
            [
                'email' => 'gandalf@the.grey',
            ],
            [
                'email',
                'name',
            ],
        ];
        yield [
            [
                'name' => 'gandalf',
            ],
            [
                'email',
                'name',
            ],
        ];
        yield [
            [
                'email' => 'gandalf@the.grey',
                'name'  => 'gandalf',
            ],
            [
                'email',
                'name',
            ],
        ];
        yield [
            [
                'name'  => 'gandalf',
                'email' => 'gandalf@the.grey',
            ],
            [
                'email',
                'name',
            ],
        ];
        yield [
            [
                'email' => 'gandalf@the.grey',
            ],
            [
                'name',
                'email',
            ],
        ];
        yield [
            [
                'name' => 'gandalf',
            ],
            [
                'name',
                'email',
            ],
        ];
        yield [
            [
                'email' => 'gandalf@the.grey',
                'name'  => 'gandalf',
            ],
            [
                'name',
                'email',
            ],
        ];
        yield [
            [
                'name'  => 'gandalf',
                'email' => 'gandalf@the.grey',
            ],
            [
                'name',
                'email',
            ],
        ];
    }

    public static function unallowedLoginDataProvider(): \Iterator
    {
        yield [
            [
                'name' => 'gandalf',
            ],
            [
                'email',
            ],
        ];
        yield [
            [
                'email' => 'gandalf@the.grey',
            ],
            [
                'name',
            ],
        ];
    }

    public function testUsesEmailFieldAsDefaultLoginFieldFallback(): void
    {
        config()->unset('appSection-authentication.login.fields');
        $credentials = [
            'email'    => 'gandalf@the.grey',
            'password' => 'youShallNotPass',
        ];
        $model = UserFactory::new()->createOne($credentials);
        $loginRequest = LoginRequest::injectData($credentials);
        $action = app(WebLoginAction::class);

        $action->run($loginRequest);

        $this->assertAuthenticatedAs($model, AuthGuard::WEB->value);
    }

    #[DataProvider('allowedLoginDataProvider')]
    public function testCanAuthenticateUsingAllowedLoginFields(array $loginFields, array $allowedFields): void
    {
        config()->set('appSection-authentication.login.fields', $this->prepareForConfig($allowedFields));
        $credentials = [
            ...$loginFields,
            'password' => 'youShallNotPass',
        ];
        $model = UserFactory::new()->createOne($credentials);
        $loginRequest = LoginRequest::injectData($credentials);
        $action = app(WebLoginAction::class);

        $action->run($loginRequest);

        $this->assertAuthenticatedAs($model, AuthGuard::WEB->value);
    }

    #[DataProvider('unallowedLoginDataProvider')]
    public function testCanAuthenticateUsingOnlyAllowedLoginFields(array $loginFields, array $allowedFields): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No matching login field found');

        config()->set('appSection-authentication.login.fields', $this->prepareForConfig($allowedFields));
        $credentials = [
            ...$loginFields,
            'password' => 'youShallNotPass',
        ];
        UserFactory::new()->createOne($credentials);
        $loginRequest = LoginRequest::injectData($credentials);
        $action = app(WebLoginAction::class);

        $action->run($loginRequest);
    }

    public function testCanReturnMultipleErrors(): void
    {
        config()->set('appSection-authentication.login.fields', ['email' => [], 'name' => []]);
        $credentials = [
            'email'    => 'gandalf@the.grey',
            'name'     => 'gandalf',
            'password' => 'youShallNotPass',
        ];
        UserFactory::new()->createOne($credentials);
        $mock = Auth::spy();
        $mock->allows()->guard(AuthGuard::WEB->value)->andReturnSelf();
        $mock->allows()->attempt($credentials)->andReturn(false);
        $loginRequest = LoginRequest::injectData($credentials);
        $action = app(WebLoginAction::class);

        $response = $action->run($loginRequest);

        /** @var MessageBag $errors */
        $errors = $response->getSession()->get('errors');
        foreach (['email', 'name'] as $field) {
            self::assertTrue($errors->has($field));
            self::assertCount(1, $errors->get($field));
            self::assertSame(__('auth.failed'), $errors->get($field)[0]);
        }

        self::assertTrue($response->isRedirect());
    }

    public function testCanLoginWithMultipleLoginFieldsEvenIfOneFieldIsCorrect(): void
    {
        config()->set('appSection-authentication.login.fields', ['email' => [], 'name' => []]);
        $userDetails = [
            'email'    => 'ganldalf@the.grey',
            'name'     => 'gandalf',
            'password' => 'youShallNotPass',
        ];
        $model = UserFactory::new()->createOne($userDetails);
        $credentials = [
            'email'    => 'ganldalf@the.white', // wrong email
            'name'     => 'gandalf', // correct name
            'password' => 'youShallNotPass',
        ];
        $loginRequest = LoginRequest::injectData($credentials);
        $action = app(WebLoginAction::class);

        $response = $action->run($loginRequest);

        self::assertTrue($response->isRedirect());
        $this->assertAuthenticatedAs($model, AuthGuard::WEB->value);
    }

    private function prepareForConfig(array $allowedFields): array
    {
        $config = [];
        foreach ($allowedFields as $allowedField) {
            $config[$allowedField] = [];
        }

        return $config;
    }
}
