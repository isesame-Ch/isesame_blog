<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;



use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     * @param Exception $e
     * @return mixed|void
     * @throws Exception
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        //if (env('APP_ENV') == 'prod' || env('APP_ENV') == 'true') {
        if (true) {
            if ($e instanceof NotFoundHttpException) {
                return response([
                    'code' => 404,
                    'message' => 'The api you request is not found!!',
                    'content' => '',
                    'contentEncrypt' => ''
                ])->setStatusCode(200);
            } else if ($e instanceof MethodNotAllowedHttpException) {
                return response([
                    'code' => 500,
                    'message' => 'The api you request is not found!',
                    'content' => '',
                    'contentEncrypt' => ''
                ])->setStatusCode(200);
            } else if ($e instanceof ValidationException) {
                return response([
                    'code' => $e->getResponse()->getStatusCode(),//getStatusCode()
                    'message' => '数据校验失败',
                    'content' => json_decode($e->getResponse()->getContent(), true),
                    'contentEncrypt' => ''
                ])->setStatusCode(200);
            } else {
                $message = $e->getMessage();
                if (strpos($message, 'SQL') !== false) {
                    $message = '数据库错误';
                    $this->logDatabaseError($request, $e);
                }
                return response([
                    'code' => $e->getCode() == 0 ? 500 : $e->getCode(),
                    'message' => $message ? $message : '未知异常',
                    'content' => '',
                    'contentEncrypt' => ''
                ])->setStatusCode(200);
            }
        }
        return parent::render($request, $e);

    }
}