<?php

namespace App\Exceptions;

use App\Traits\ResponseAPI;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseAPI;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

    /*public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|Response
    {
        return match (get_class($e)) {
            QueryException::class => $this->error($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY),
            AuthenticationException::class => $this->error($e->getMessage(), Response::HTTP_UNAUTHORIZED),
            ThrottleRequestsException::class => $this->error($e->getMessage(), Response::HTTP_TOO_MANY_REQUESTS),
            default => $this->error($e->getMessage(), $e->getCode()),
        };

    }*/
}
