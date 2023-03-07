<?php

namespace App\Exceptions;

use App\Http\Controllers\api\v1\ApiController;
use App\Traits\RestfulTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use spatie\Permission\Exceptions\UnauthorizedException as ExceptionSpatieUnauthorized;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    use RestfulTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e)
    {
        return $this->handleException($request, $e);
    }
    public function handleException($request, Throwable $exception)
    {

        if ($exception instanceof AuthenticationException) {
            return $this->apiResponse('', ApiController::STATUS_NOT_AUTHENTICATED,$exception->getMessage());
        }

        if ($exception instanceof AuthorizationException) {
            return $this->apiResponse('', ApiController::STATUS_UNAUTHORIZED,$exception->getMessage());
        }

        if ($exception instanceof ExceptionSpatieUnauthorized) {
            return $this->apiResponse('', ApiController::STATUS_UNAUTHORIZED,$exception->getMessage());
        }

        if ($exception instanceof HttpException) {
            return $this->apiResponse('', ApiController::STATUS_BAD_REQUEST,$exception->getMessage());
        }

        if ($exception instanceof HttpResponseException) {
            return $this->apiResponse('', ApiController::STATUS_FORBIDDEN,$exception->getMessage());
        }

//        if ($exception instanceof ValidationException) {
//            return $this->apiResponse('', ApiController::STATUS_VALIDATION,$exception->getMessage());
//        }
        if ($exception instanceof ValidationException) {
            $msg = [
                'text' => $exception->getMessage(),
                'errors' => $exception->errors()
            ];
            return $this->apiResponse('', ApiController::STATUS_VALIDATION,$msg);
        }
        if ($exception instanceof ModelNotFoundException) {
            return $this->apiResponse('', ApiController::STATUS_NOT_FOUND,$exception->getMessage());
        }
        if ($exception instanceof RouteNotFoundException) {
            if($exception->getMessage()=='Route [login] not defined.')
                return $this->apiResponse('', ApiController::STATUS_NOT_AUTHENTICATED,'you should login');
        }
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        return $this->apiResponse('', ApiController::STATUS_NOT_FOUND,$exception->getMessage());

    }
}
