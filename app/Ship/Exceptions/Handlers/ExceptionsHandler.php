<?php

declare(strict_types=1);

namespace App\Ship\Exceptions\Handlers;

use Apiato\Core\Abstracts\Exceptions\Exception as CoreException;
use Apiato\Core\Exceptions\AuthenticationException as CoreAuthenticationException;
use Apiato\Core\Exceptions\Handlers\ExceptionsHandler as CoreExceptionsHandler;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\LoginPageController;
use App\Containers\AppSection\Authorization\UI\WEB\Controllers\UnauthorizedPageController;
use App\Ship\Exceptions\AccessDeniedException;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Providers\RouteServiceProvider;
use Illuminate\Auth\AuthenticationException as LaravelAuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * Class ExceptionsHandler.
 * A.K.A. app/Exceptions/Handler.php.
 */
class ExceptionsHandler extends CoreExceptionsHandler
{
    private const string WEB_UI_NAME = 'web';

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    #[\Override]
    public function register(): void
    {
        $this->reportable(static function (Throwable $e): void {
        });

        $this->renderable(function (CoreException $e, $request) {
            if ($this->shouldReturnJson($request, $e)) {
                return $this->buildJsonResponse($e);
            }

            return $this->renderExceptionResponse($request, $e);
        });

        $this->renderable(function (NotFoundHttpException|ModelNotFoundException $e, $request) {
            if ($this->shouldReturnJson($request, $e)) {
                return $this->buildJsonResponse(new NotFoundException());
            }

            return $this->renderExceptionResponse($request, $e);
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {
            if ($this->shouldReturnJson($request, $e)) {
                return $this->buildJsonResponse(new AccessDeniedException());
            }

            $route = config('apiato.ship.guest-ui-route') === self::WEB_UI_NAME
                ? action(UnauthorizedPageController::class)
                : route(RouteServiceProvider::UNAUTHORIZED);

            return redirect()->guest($route);
        });
    }

    #[\Override]
    protected function unauthenticated($request, LaravelAuthenticationException $exception): JsonResponse|RedirectResponse
    {
        if ($this->shouldReturnJson($request, $exception)) {
            return $this->buildJsonResponse(new CoreAuthenticationException());
        }

        $route = config('apiato.ship.guest-ui-route') === self::WEB_UI_NAME
            ? action(LoginPageController::class)
            : route(RouteServiceProvider::LOGIN);

        return redirect()->guest($route);
    }

    private function buildJsonResponse(CoreException $e): JsonResponse
    {
        $response = [
            'message' => $e->getMessage(),
            'errors'  => $e->getErrors(),
        ];

        if (app()->isProduction() === false) {
            $response = array_merge($response, [
                'exception' => $e::class,
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
                'trace'     => $e->getTrace(),
            ]);
        }

        return response()->json($response, (int) $e->getCode());
    }
}
