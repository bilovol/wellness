<?php

namespace App\Exceptions;

use App\Http\Responses\JsonResponse;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        UnauthorizedException::class,
        ForbiddenException::class,
        NotFoundHttpException::class,
        ModelNotFoundException::class,
        MethodNotAllowedHttpException::class,
        ValidationException::class,
        AuthorizationException::class,
        HttpException::class,
    ];

    /**
     * @param Throwable $e
     * @return void
     * @throws Exception
     */
    public function report(Throwable $e)
    {
        if ($this->shouldReport($e)) {
            //need report this
        }

        parent::report($e);
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     */
    public function render($request, Throwable $e): JsonResponse
    {
        //401
        if ($e instanceof UnauthorizedException) {
            return (new JsonResponse())
                ->setError($e->getMessage())
                ->setCode($e->getCode())
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }


        //403
        if ($e instanceof ForbiddenException) {
            return (new JsonResponse())
                ->setError($e->getMessage())
                ->setCode($e->getCode())
                ->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        //404
        if ($e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException) {
            return (new JsonResponse())
                ->setError('Not Found!')
                ->setCode(Response::HTTP_NOT_FOUND)
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        //405
        if ($e instanceof MethodNotAllowedHttpException) {
            return (new JsonResponse())
                ->setError('Method not allowed!')
                ->setCode(Response::HTTP_METHOD_NOT_ALLOWED)
                ->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED);
        }

        //422
        if ($e instanceof ValidationException) {
            return (new JsonResponse())
                ->setError($e->validator->errors()->first())
                ->setCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //500
        return (new JsonResponse())
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->setError('Interval server error!')
            ->setTrace(config('app.debug')
                ? $e->getMessage() . ' | ' . $e->getTraceAsString() . ':' . $e->getLine()
                : '');
    }
}
