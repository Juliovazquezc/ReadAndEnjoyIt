<?php

namespace App\Exceptions;

use App\Traits\HttpResponseFailure;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use HttpResponseFailure;

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

        $this->renderable( function (NotFoundHttpException $error) {
            return $this->httpResponseFailure(
                __('error.not_found'),
                $error->getStatusCode()
            );
        });

        $this->renderable(function (HttpException $error) {
            return $this->httpResponseFailure(
                $error->getMessage(),
                $error->getStatusCode()
            );
        });

        $this->renderable(function (PDOException $error) {
            return $this->httpResponseFailure(
                __('error.database', ['errorCode' => $error->getCode()]),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        });
    }
    
}
