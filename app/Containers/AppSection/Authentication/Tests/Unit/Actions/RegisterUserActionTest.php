<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\RegisterUserAction;
use App\Containers\AppSection\Authentication\Notifications\VerifyEmail;
use App\Containers\AppSection\Authentication\Notifications\Welcome;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RegisterUserAction::class)]
final class RegisterUserActionTest extends UnitTestCase
{
    public function testRegisterUser(): void
    {
        Notification::fake();
        $data = [
            'email'            => 'gandalf@the.grey',
            'password'         => 'youShallNotPass',
            'verification_url' => config('appSection-authentication.allowed-verify-email-urls')[0],
        ];
        $registerUserRequest = RegisterUserRequest::injectData($data);
        $action = app(RegisterUserAction::class);

        $user = $action->run($registerUserRequest);

        $this->assertModelExists($user);
        self::assertInstanceOf(User::class, $user);
        self::assertSame(strtolower($data['email']), $user->email);
        self::assertTrue(Hash::check($data['password'], $user->password));
        self::assertNull($user->email_verified_at);
        Notification::assertSentTo($user, Welcome::class);

        if (config('appSection-authentication.require_email_verification')) {
            Notification::assertSentTo($user, VerifyEmail::class);
        }
    }
}
